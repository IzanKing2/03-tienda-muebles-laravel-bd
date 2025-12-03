<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{

    // Mostrar el contenido del carrito
    public function index()
    {
        // Obtener carrito de sesión (array con productos)
        $carritoSesion = Session::get('carrito', []);

        // Calcular subtotal (suma de precio * cantidad)
        $subtotal = 0;
        foreach ($carritoSesion as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }

        // Calcular impuestos (10% del subtotal)
        $impuestos = $subtotal * 0.10;

        // Total = subtotal + impuestos
        $total = $subtotal + $impuestos;

        // Pasar datos a la vista
        return view('carrito.index', compact('carritoSesion', 'subtotal', 'impuestos', 'total'));
    }

    // Añadir un producto al carrito
    public function agregar(Request $request, $id)
    {
        // Buscar el producto por ID
        $producto = Producto::find($id);

        // Validar que el producto existe
        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        // VALIDACIÓN DE STOCK: No hay stock disponible
        if ($producto->stock <= 0) {
            return redirect()->back()->with('error', "No hay stock disponible para: {$producto->nombre}");
        }

        // Obtener carrito actual de sesión
        $carrito = Session::get('carrito', []);

        if (isset($carrito[$id])) {
            // El producto ya está en el carrito: incrementar cantidad

            // Validar que no exceda el stock al incrementar
            if ($carrito[$id]['cantidad'] + 1 > $producto->stock) {
                return redirect()->back()->with(
                    'error',
                    "Stock insuficiente para {$producto->nombre}. Disponible: {$producto->stock}"
                );
            }
            $carrito[$id]['cantidad']++;
        } else {
            // Producto nuevo: añadirlo al carrito
            $carrito[$id] = [
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'imagen' => $producto->imagen_principal ?? null,
                'producto_id' => $id,
            ];
        }

        // Guardar carrito actualizado en sesión
        Session::put('carrito', $carrito);

        // Redirigir al carrito con mensaje de éxito
        return redirect()->route('carrito.index')->with(
            'success',
            "✅ {$producto->nombre} añadido al carrito."
        );
    }

    // Actualizar la cantidad de un producto en el carrito
    public function actualizar(Request $request)
    {
        // Validar datos
        $request->validate([
            'producto_id' => 'required|integer|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        // Buscar el producto
        $producto = Producto::find($request->producto_id);
        $carrito = Session::get('carrito', []);

        // VALIDACIÓN DE STOCK: Verificar que hay suficiente stock
        if ($request->cantidad > $producto->stock) {
            return redirect()->back()->with(
                'error',
                "Stock insuficiente. Disponible: {$producto->stock}"
            );
        }

        // Verificar que el producto está en el carrito
        if (isset($carrito[$request->producto_id])) {
            // Actualizar cantidad
            $carrito[$request->producto_id]['cantidad'] = $request->cantidad;
            Session::put('carrito', $carrito);

            return redirect()->route('carrito.index')->with('success', '✅ Cantidad actualizada.');
        }

        return redirect()->back()->with('error', 'Producto no encontrado en el carrito.');
    }

    // Eliminar un producto del carrito
    public function eliminar($id)
    {
        $carrito = Session::get('carrito', []);

        if (isset($carrito[$id])) {
            $nombreProducto = $carrito[$id]['nombre'];
            unset($carrito[$id]);
            Session::put('carrito', $carrito);

            return redirect()->route('carrito.index')->with(
                'success',
                "✅ {$nombreProducto} eliminado del carrito."
            );
        }

        return redirect()->back()->with('error', 'Producto no encontrado en el carrito.');
    }

    // Vaciar todo el carrito
    public function vaciar()
    {
        Session::forget('carrito');

        return redirect()->route('carrito.index')->with('success', '✅ Carrito vaciado correctamente.');
    }

    // Guardar el carrito en la base de datos como un pedido
    public function guardarEnBD()
    {
        // VALIDAR AUTENTICACIÓN
        if (!Auth::check()) {
            return redirect()->route('login')->with(
                'error',
                'Debes iniciar sesión para guardar el carrito.'
            );
        }

        // OBTENER CARRITO DE SESIÓN
        $carritoSesion = Session::get('carrito', []);

        // VALIDAR QUE NO ESTÉ VACÍO
        if (empty($carritoSesion)) {
            return redirect()->route('carrito.index')->with(
                'error',
                'El carrito está vacío.'
            );
        }

        // VALIDACIÓN DE STOCK: Verificar que hay stock para TODOS los productos
        foreach ($carritoSesion as $id => $item) {
            $producto = Producto::find($id);

            // Producto no existe
            if (!$producto) {
                return redirect()->route('carrito.index')->with(
                    'error',
                    "Producto no encontrado: {$item['nombre']}"
                );
            }

            // Stock insuficiente
            if ($producto->stock < $item['cantidad']) {
                return redirect()->route('carrito.index')->with(
                    'error',
                    "Stock insuficiente para: {$item['nombre']}. Disponible: {$producto->stock}"
                );
            }
        }

        try {
            DB::beginTransaction();

            // CREAR REGISTRO EN LA TABLA CARRITOS
            $carrito = Carrito::create([
                'usuario_id' => Auth::id(),
                'sesion_id' => session()->getId(), // ID único de sesión/navegador
                'total' => 0,
            ]);

            $totalCarrito = 0;

            // GUARDAR CADA ITEM EN LA TABLA CARRITO_ITEMS Y REDUCIR STOCK
            foreach ($carritoSesion as $id => $item) {
                CarritoItem::create([
                    'carrito_id' => $carrito->id,
                    'producto_id' => $id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);

                // Reducir stock del producto
                $producto = Producto::find($id);
                $producto->reducirStock($item['cantidad']);

                // Calcular el total
                $totalCarrito += $item['cantidad'] * $item['precio'];
            }

            // GUARDAR EL TOTAL EN EL CARRITO
            $carrito->update(['total' => $totalCarrito]);

            DB::commit();

            // VACIAR LA SESIÓN (carrito de sesión)
            Session::forget('carrito');

            // REDIRIGIR CON ÉXITO
            return redirect()->route('carrito.index')->with(
                'success',
                "✅ ¡Pedido guardado correctamente! ID del pedido: #{$carrito->id}"
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('carrito.index')->with(
                'error',
                'Ocurrió un error al procesar el pedido: ' . $e->getMessage()
            );
        }
    }

    // Ver historial de pedidos del usuario
    public function historial()
    {
        // Validar autenticación
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Obtener todos los carritos del usuario autenticado, con sus items
        $carritos = Carrito::where('usuario_id', Auth::id())
            ->with('items.producto') // Eager loading para optimizar
            ->orderBy('created_at', 'desc') // Más recientes primero
            ->paginate(10); // Paginación: 10 por página

        return view('carrito.historial', compact('carritos'));
    }

    // Guardar preferencias del usuario en cookies
    public function GuardarCookiePreferencia(Request $request)
    {
        $paginacion = $request->input('paginacion');
        $tema = $request->input('tema');
        $moneda = $request->input('moneda');

        if ($paginacion) {
            Cookie::queue('paginacion', $paginacion, 60 * 24 * 30); // 30 días
        }
        if ($tema) {
            Cookie::queue('tema', $tema, 60 * 24 * 30);
        }
        if ($moneda) {
            Cookie::queue('moneda', $moneda, 60 * 24 * 30);
        }

        return redirect()->back()->with('success', 'Preferencias guardadas correctamente.');
    }

    public function verDetalles($id)
    {
        // Validar autenticación
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Buscar el carrito con sus items y productos
        $carrito = Carrito::with('items.producto')
            ->findOrFail($id);

        // SEGURIDAD: Validar que el carrito pertenezca al usuario autenticado
        if ($carrito->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este carrito.');
        }

        // Calcular subtotal (suma de cantidad * precio_unitario)
        $subtotal = $carrito->items->sum(fn($item) => $item->cantidad * $item->precio_unitario);

        // Calcular impuestos (10%)
        $impuestos = $subtotal * 0.10;

        // Total
        $total = $subtotal + $impuestos;

        return view('carrito.detalles', compact('carrito', 'subtotal', 'impuestos', 'total'));
    }
}


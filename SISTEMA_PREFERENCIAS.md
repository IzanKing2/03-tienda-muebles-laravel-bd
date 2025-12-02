# Sistema de Preferencias de Usuario - Guía Completa

## 📋 Resumen

Se ha implementado un sistema completo de preferencias de usuario que:

1. **Guarda preferencias en cookies** para usuarios no autenticados
2. **Migra automáticamente las cookies a la base de datos** cuando el usuario inicia sesión o se registra
3. **Almacena preferencias en la BD** para usuarios autenticados
4. **Carga preferencias** desde la fuente correcta según el estado de autenticación

## 🗂️ Archivos Modificados y Creados

### Base de Datos

#### ✨ NUEVO: `database/migrations/2025_12_02_190000_add_preferences_to_users_table.php`
Migración que agrega tres campos a la tabla `users`:
- `tema` (string, default: 'light')
- `moneda` (string, default: '€')
- `paginacion` (integer, default: 12)

**Para ejecutar la migración:**
```bash
php artisan migrate
```

### Modelos

#### 📝 MODIFICADO: `app/Models/User.php`
Se agregaron los campos de preferencias al array `$fillable`:
```php
protected $fillable = [
    'nombre',
    'apellidos',
    'email',
    'password',
    'rol_id',
    'tema',        // ← NUEVO
    'moneda',      // ← NUEVO
    'paginacion',  // ← NUEVO
];
```

### Controladores

#### 📝 MODIFICADO: `app/Http/Controllers/CarritoController.php`

**Método implementado: `GuardarCookiePreferencia`**

Este método:
1. Valida los datos recibidos (paginacion, tema, moneda)
2. Crea cookies con duración de 365 días
3. Retorna respuesta JSON con las cookies adjuntas

```php
public function GuardarCookiePreferencia(Request $request)
{
    // Validar datos
    $validated = $request->validate([
        'paginacion' => 'required|integer|in:6,12,24,48',
        'tema' => 'required|string|in:light,dark',
        'moneda' => 'required|string|in:€,$,£',
    ]);

    // Crear cookies (365 días)
    $duracion = 365 * 24 * 60;
    
    // Retornar JSON con cookies
    return response()->json([...])
        ->cookie('paginacion', $paginacion, $duracion)
        ->cookie('tema', $tema, $duracion)
        ->cookie('moneda', $moneda, $duracion);
}
```

#### 📝 MODIFICADO: `app/Http/Controllers/AuthController.php`

**Método `login` actualizado:**
- Después de autenticar, llama a `migrarPreferenciasDeCookies()`
- Migra las preferencias de cookies a la base de datos

**Método `register` actualizado:**
- Después de crear el usuario, llama a `aplicarPreferenciasDeCookies()`
- Aplica las preferencias de cookies al nuevo usuario

**Nuevos métodos privados:**

```php
private function migrarPreferenciasDeCookies(Request $request)
{
    // Verifica si existen cookies de preferencias
    // Las guarda en la BD del usuario autenticado
}

private function aplicarPreferenciasDeCookies(Request $request, User $user)
{
    // Verifica si existen cookies de preferencias
    // Las aplica al usuario recién creado
}
```

#### 📝 MODIFICADO: `app/Http/Controllers/PreferenceController.php`

**Método `index`:**
- Obtiene preferencias usando `getPreferences()`
- Pasa las preferencias a la vista

**Método `update` (NUEVO):**
- Solo para usuarios autenticados
- Valida y actualiza preferencias en la BD
- Redirige con mensaje de éxito

**Método privado `getPreferences`:**
- Si el usuario está autenticado: obtiene de la BD
- Si el usuario NO está autenticado: obtiene de cookies
- Retorna valores por defecto si no existen

### Rutas

#### 📝 MODIFICADO: `routes/web.php`

Se agregaron dos nuevas rutas:

```php
// Guardar preferencias en cookies (usuarios no autenticados)
Route::post('/preferences/cookie', [CarritoController::class, 'GuardarCookiePreferencia'])
    ->name('preferences.cookie');

// Actualizar preferencias en BD (usuarios autenticados)
Route::put('/preferences', [PreferenceController::class, 'update'])
    ->name('preferences.update')
    ->middleware('auth');
```

### Vistas

#### 📝 MODIFICADO: `resources/views/preferences/index.blade.php`

**Cambios principales:**

1. **Formulario dinámico:**
   - Action cambia según autenticación: `preferences.update` (autenticado) o `preferences.cookie` (invitado)
   - Método cambia: PUT (autenticado) o POST (invitado)

2. **Mensajes de sesión:**
   - Muestra mensajes de éxito/error

3. **JavaScript para usuarios no autenticados:**
   - Intercepta el submit del formulario
   - Envía datos via AJAX a `/preferences/cookie`
   - Recarga la página para aplicar las preferencias

```javascript
// Solo para usuarios NO autenticados
fetch('/preferences/cookie', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
    },
    body: JSON.stringify(data)
})
```

## 🔄 Flujo de Funcionamiento

### Caso 1: Usuario NO autenticado cambia preferencias

1. Usuario va a `/preferences`
2. Cambia tema, moneda o paginación
3. Al hacer submit:
   - JavaScript intercepta el formulario
   - Envía datos via AJAX a `POST /preferences/cookie`
   - `CarritoController::GuardarCookiePreferencia` crea las cookies
   - Página se recarga con las nuevas preferencias

### Caso 2: Usuario NO autenticado inicia sesión

1. Usuario tiene cookies de preferencias establecidas
2. Usuario inicia sesión en `/login`
3. `AuthController::login` autentica al usuario
4. Llama a `migrarPreferenciasDeCookies()`
5. Las preferencias de las cookies se guardan en la BD
6. Usuario redirigido a home con sus preferencias guardadas

### Caso 3: Usuario NO autenticado se registra

1. Usuario tiene cookies de preferencias establecidas
2. Usuario se registra en `/register`
3. `AuthController::register` crea el nuevo usuario
4. Llama a `aplicarPreferenciasDeCookies()`
5. Las preferencias de las cookies se aplican al nuevo usuario
6. Usuario redirigido a home con sus preferencias guardadas

### Caso 4: Usuario autenticado cambia preferencias

1. Usuario autenticado va a `/preferences`
2. Cambia tema, moneda o paginación
3. Al hacer submit:
   - Formulario se envía como PUT a `/preferences`
   - `PreferenceController::update` valida y guarda en BD
   - Usuario redirigido con mensaje de éxito

## 🎯 Cómo Usar las Preferencias en Otras Partes

Para obtener las preferencias del usuario actual en cualquier controlador o vista:

### En Controladores:

```php
use Illuminate\Support\Facades\Auth;

// Obtener preferencias del usuario autenticado
if (Auth::check()) {
    $tema = Auth::user()->tema;
    $moneda = Auth::user()->moneda;
    $paginacion = Auth::user()->paginacion;
}

// Obtener preferencias de cookies (usuario no autenticado)
$tema = request()->cookie('tema', 'light');
$moneda = request()->cookie('moneda', '€');
$paginacion = request()->cookie('paginacion', 12);
```

### En Vistas Blade:

```blade
@auth
    {{-- Usuario autenticado --}}
    <p>Tu tema es: {{ auth()->user()->tema }}</p>
    <p>Tu moneda es: {{ auth()->user()->moneda }}</p>
@else
    {{-- Usuario no autenticado --}}
    <p>Tema: {{ request()->cookie('tema', 'light') }}</p>
@endauth
```

## ⚙️ Configuración de Valores

### Valores permitidos:

**Tema:**
- `light` (Claro) - por defecto
- `dark` (Oscuro)

**Moneda:**
- `€` (Euro) - por defecto
- `$` (Dólar)
- `£` (Libra)

**Paginación:**
- `6` elementos
- `12` elementos - por defecto
- `24` elementos
- `48` elementos

## 🚀 Próximos Pasos

1. **Ejecutar la migración:**
   ```bash
   php artisan migrate
   ```

2. **Probar el flujo completo:**
   - Sin autenticar: cambiar preferencias → verificar cookies
   - Iniciar sesión → verificar que las preferencias se migraron a BD
   - Cambiar preferencias autenticado → verificar que se guardan en BD

3. **Aplicar las preferencias en la aplicación:**
   - Usar el tema para cambiar estilos CSS
   - Usar la moneda para mostrar precios
   - Usar la paginación en listados de productos

## 📝 Notas Importantes

- Las cookies tienen una duración de **365 días**
- Las preferencias se migran **automáticamente** al iniciar sesión o registrarse
- Los usuarios autenticados **siempre** usan la BD, no cookies
- Los valores por defecto se aplican si no hay preferencias guardadas
- La validación asegura que solo se guarden valores permitidos

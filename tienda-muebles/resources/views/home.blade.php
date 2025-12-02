@extends('layout.cabecera')
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
        color: #333;
    }

    .contenedor-principal {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    h1,
    h2,
    h3 {
        color: #4a4a4a;
    }

    a {
        text-decoration: none;
        color: #5c4033;
        transition: color 0.3s;
    }

    a:hover {
        color: #7b5b4e;
    }

    .encabezado {
        background-color: #fff;
        padding: 30px 0;
        text-align: center;
        border-bottom: 3px solid #e0e0e0;
    }

    .encabezado h1 {
        font-size: 2.5em;
        margin-bottom: 5px;
        color: #5c4033;
    }

    .encabezado p {
        font-size: 1.1em;
        color: #777;
        margin-top: 0;
    }

    .banner-principal {
        position: relative;
        width: 100%;
        margin-bottom: 40px;
        overflow: hidden;
    }

    .banner-principal img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
        max-height: 400px;
    }

    .banner-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .banner-overlay a {
        display: inline-block;
        background-color: #5c4033;
        color: white;
        padding: 15px 30px;
        font-size: 1.2em;
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .banner-overlay a:hover {
        background-color: #7b5b4e;
    }

    .seccion-categorias {
        padding: 20px 0;
        text-align: center;
    }

    .grid-categorias {
        display: flex;
        justify-content: space-around;
        gap: 20px;
        margin-top: 20px;
    }

    .tarjeta-categoria {
        flex: 1;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .tarjeta-categoria:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .tarjeta-categoria h3 {
        margin-top: 0;
        color: #4b3828;
    }

    .seccion-productos {
        padding: 40px 0;
    }

    .seccion-productos h2 {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
    }

    .grid-productos {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .tarjeta-producto {
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s;
    }

    .tarjeta-producto:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .tarjeta-producto img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .info-producto {
        padding: 15px;
    }

    .info-producto h3 {
        margin-top: 0;
        font-size: 1.3em;
    }

    .info-producto p {
        margin: 5px 0;
    }

    .info-producto p:last-of-type {
        font-weight: bold;
        color: #28a745;
        font-size: 1.1em;
    }

    .info-producto a {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 15px;
        background-color: #5c4033;
        color: white;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .info-producto a:hover {
        background-color: #7b5b4e;
    }

    @media (max-width: 900px) {
        .grid-categorias {
            flex-wrap: wrap;
        }

        .tarjeta-categoria {
            flex-basis: calc(50% - 10px);
            margin-bottom: 20px;
        }
    }

    @media (max-width: 600px) {
        .encabezado h1 {
            font-size: 2em;
        }

        .tarjeta-categoria {
            flex-basis: 100%;
        }

        .grid-productos {
            grid-template-columns: 1fr;
        }

        .banner-overlay a {
            padding: 10px 20px;
            font-size: 1em;
        }
    }
</style>

@section('content')
    <div class="contenedor-principal">
        <header class="encabezado">
            <h1>Bienvenido a tu tienda de Muebles</h1>
            <p>Encuentra muebles únicos para tu hogar</p>
        </header>

        <div class="banner-principal">
            <img src="https://ima.europamuebles.com/tifonima/pi/salones/54108/composicion-salon-avignon_0_0_6AMO.jpg"
                alt="Banner">
            <div class="banner-overlay">
                <a href="#productos">Ver Productos</a>
            </div>
        </div>

        <section class="seccion-categorias">
            <h2>Categorías</h2>
            <div class="grid-categorias">
                <div class="tarjeta-categoria">
                    <h3>Salas</h3>
                    <p>Muebles cómodos y elegantes para tu sala.</p>
                </div>
                <div class="tarjeta-categoria">
                    <h3>Dormitorios</h3>
                    <p>Camas, mesitas de noche y más para tu descanso.</p>
                </div>
                <div class="tarjeta-categoria">
                    <h3>Comedores</h3>
                    <p>Mesas y sillas perfectas para compartir.</p>
                </div>
            </div>
        </section>

        <section id="productos" class="seccion-productos">
            <h2>Productos Destacados</h2>
            <div class="grid-productos">
                @foreach($products as $producto)
                    <div class="tarjeta-producto">
                        <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}">
                        <div class="info-producto">
                            <h3>{{ $producto->nombre }}</h3>
                            <p>{{ $producto->descripcion }}</p>
                            <p>$ {{ number_format($producto->precio, 2) }}</p>
                            <a href="{{ route('products.show', $producto->id) }}">Ver más</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
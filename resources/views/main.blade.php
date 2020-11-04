<!doctype html>
<x-app-layout>
<html lang="en">
<x-slot name="header">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
                  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
                  crossorigin="anonymous">
            <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <title>Main</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/pricing/">

    <!-- Bootstrap core CSS -->
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="{{asset('css/pricing.css')}}" rel="stylesheet">
  </head>

  <body>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">YoEstuveAhi</h1>
      <p class="lead">Apps de trazabilidad ante contagios COVID</p>
    </div>

    <div class="container">
      <div class="card-deck mb-4 text-center">
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Locacion</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled mt-3 mb-4">
              <li>Registrar locacion</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-outline-primary" onclick="location.href='location'">Locacion</button>
          </div>
          </div>
          @role('administrator')
          <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Estadísticas del sistema</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled mt-3 mb-4">
              <li>Ver estadísticas</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-outline-primary" onclick="location.href='admin'">Estadísticas del sistema</button>
          </div>
        </div>
          @endrole
          <div class="card mb-4 shadow-sm">
          <div class="card-header">
            @if(Auth::user()->locacion == 0)
                <h4 class="my-0 font-weight-normal">CheckIn</h4>
            @else
                <h4 class="my-0 font-weight-normal">CheckOut</h4>
            @endif
          </div>
          <div class="card-body">
            <ul class="list-unstyled mt-3 mb-4">
                @if(Auth::user()->locacion == 0)
                    <li>Realizar CheckIn</li>
                @else
                    <li>Realizar CheckOut</li>
                @endif
            </ul>
              @if(Auth::user()->locacion == 0)
                <button type="button" class="btn btn-lg btn-block btn-primary" onclick="abrirCamara()" id="check">CheckIn</button>
              @else
                  <button type="button" class="btn btn-lg btn-block btn-primary" onclick="abrirCamara()" id="check">CheckOut</button>
              @endif
              <script src="{{ asset('js/camara.js') }}"></script>
          </div>
          </div>
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
              @if(Auth::user()->estado == 'No contagiado')
                    <h4 class="my-0 font-weight-normal">Contagiado</h4>
              @elseif(Auth::user()->estado == 'En riesgo')
                  <h4 class="my-0 font-weight-normal">Resultado del test</h4>
              @else
                  <h4 class="my-0 font-weight-normal">Testeo negativo</h4>
              @endif
                  </div>
          <div class="card-body">
                    <ul class="list-unstyled mt-3 mb-4">
                    @if(Auth::user()->estado == 'No contagiado')
                      <li>Avisar estas contagiado</li>
                    @elseif(Auth::user()->estado == 'Contagiado')
                            <li>Avisar que tu test dio negativo</li>
                    @endif
                        </ul>
                      @if(Auth::user()->estado == 'No contagiado')
                        <form action="{{ url('/informarcontagio') }}" method="get">
                      @elseif(Auth::user()->estado == 'Contagiado')
                        <form action="{{ url('/informartest') }}" method="get">
                      @else
                                <div id="formAction"></div>
                        <script src="{{ asset('js/checkResultado.js') }}"></script>
                        <label>Seleccionar resultado</label>
                        <select name="resultado" id="resultado" style="color: #8ebc42">
                            <option value=""></option>
                            <option value="Positivo">Positivo</option>
                            <option value="Negativo">Negativo</option>
                        </select>
                      @endif
                          <div class="form-group">
                              <label>Fecha del diagnostico</label>
                              <input id='fecha' name="fecha" type="date" class="form-control" required>
                          </div>
                      @if(Auth::user()->estado == 'No contagiado')
                        <input type="submit" class="btn btn-lg btn-block btn-primary" value="Contagiado">
                      @elseif(Auth::user()->estado == 'Contagiado')
                          <input type="submit" class="btn btn-lg btn-block btn-primary" value="Test negativo">
                      @else
                          <input type="submit" class="btn btn-lg btn-block btn-primary" onclick="checkResultado();" value="Informar">
                      @endif
                        </form>
        </div>
        </div>
      </div>
    </div>

    <div class="card-footer">
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
      <h5 class="my-0 mr-md-auto font-weight-normal">YoEstuveAhi</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <h5 class="my-0 mr-md-auto font-weight-normal">Estado: </h5>
      </nav>
      @if(Auth::user()->estado == 'No contagiado')
        <a class="btn btn-success" href="#">{{ Auth::user()->estado }}</a>
      @elseif(Auth::user()->estado == 'Contagiado')
        <a class="btn btn-danger" href="#">{{ Auth::user()->estado }}</a>
      @endif
    </div>
    </div>
</body>
</x-slot>
</html>
</x-app-layout>

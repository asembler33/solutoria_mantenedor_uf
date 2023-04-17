<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mantendor Histórico UF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                  
                  <div>
                    <canvas id="myChart"></canvas>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-4">
            <label for="message-text" class="col-form-label">Fecha Desde:</label>
              <div class="input-group date" data-provide="datepicker" id="fechaDesde">
                <input type="text" class="form-control">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>    
      </div>
      <div class="col-md-4">
        <label for="message-text" class="col-form-label">Fecha Hasta:</label>
        <div class="input-group date" data-provide="datepicker" id="fechaHasta">
          <input type="text" class="form-control">
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>    
      </div>
    </div>
    <p></p>
    <p></p>
      <div class="row justify-content-center">
        <div class="col-md-2">
          <button type="button" class="btn btn-primary" name="btnBuscar" id="btnBuscar">Buscar</button>
        </div>
      </div>
  </div>
  <br>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js" integrity="sha512-poSrvjfoBHxVw5Q2awEsya5daC0p00C8SKN74aVJrs7XLeZAi+3+13ahRhHm8zdAFbI2+/SUIrKYLvGBJf9H3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   $(function() {
      $.fn.datepicker.defaults.format = 'dd-mm-yyyy';
      let valores = [];

      fetch("http://localhost:8000/verDatos")
      .then(response => response.json())
      .then(data => { 
        
          const valores = data.map(dato => dato.valorIndicador);
          
          verGrafico(valores);

          // console.log(graficoGlobal);
      });
   });


   $('#btnBuscar').click(function() {
    
     let fechaDesde = $('#fechaDesde').datepicker('getDate');
     fechaDesde = fechaDesde.toLocaleDateString('es-CL');
     console.log(fechaDesde);
     
     let fechaHasta = $('#fechaHasta').datepicker('getDate');
     fechaHasta = fechaHasta.toLocaleDateString('es-CL');

     graficoGlobal.destroy();

      $.ajax({
        type: "POST",
        url: "http://localhost:8000/procesarGrafico",
        data: {
          fechaDesde: fechaDesde,
          fechaHasta: fechaHasta
        },
        dataType: "JSON",
        success: function (response) {
          const valoresIndicadores = response.map(dato => dato.valorIndicador);
          verGrafico(valoresIndicadores);

        }
      });

      

   });

   function verGrafico(valores){
    const ctx = document.getElementById('myChart');
    var grafico = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ['Libra Cobre', 'Euro', 'Dolár', 'TPM', 'UTM', 'UF', 'IVP', 'BITCOIN', 'IPC', 'TASA EMPLEO', 'IMC'],
              datasets: [{
                label: 'Estadísticas divisas',
                data: valores,
                borderWidth: 1,
                backgroundColor: [
                  '#9BD0F5',
                  '#FFB1C1',
                  '#ff6384',
                  '#36a2eb',
                  '#cc65fe',
                  '#ffce56'
                ],
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
          window.graficoGlobal = grafico;
   }

  </script>
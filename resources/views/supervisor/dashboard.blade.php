@extends('adminlte::page')


@section('content')
<div id="barchart_material" style="width: 100%; height: 500px;"></div>
</div>
@endsection


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Product Id', 'Sales', 'Quantity'],
        
        //@foreach ($data as $key => $user)
        <?php 
          foreach($products as $product) {
              echo "['".$product->id."', ".$product->sales.", ".$product->quantity."],";
          }
        ?>;
    ]);

    var options = {
      chart: {
        title: 'Bar Graph | Sales',
        subtitle: 'Sales, and Quantity: @php echo $products[0]->created_at @endphp',
      },
      bars: 'vertical'
    };
    var chart = new google.charts.Bar(document.getElementById('barchart_material'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
  }
</script>
@stop


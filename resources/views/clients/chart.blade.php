<!doctype html>
<html lang="en">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>
</head>
<body>
  <table class="table table-striped table-bordered" width="100%" style="width:100%">
    <thead>
        <tr>
            <th>Payment Chart</th>
        </tr>
    </thead>
    <tbody>
      
        <tr>
          <td><div style="width:75%;">
            <?php if(isset($chartjs)) { 
                echo $chartjs->render();
              } ?>

          </div></td>
          
       </tr>
       
   </tbody>
</table>
</body>
</html>


 


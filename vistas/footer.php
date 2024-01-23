    <?php
        require_once "../modelos/Factura.php";
    $factura = new Factura();

    $datos = $factura->datosemp($_SESSION['idempresa']);
    $datose = $datos->fetch_object();



    ?>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1
        </div>
        <strong>Copyright &copy; 2018 <a href=""><?php  echo $datose->nombre_comercial;   ?></a>.</strong> 
    </footer>  

      
    <!-- jQuery -->
    <script src="../public/js/jquery-3.1.1.min.js"></script>
    <script src="../public/js/jquery.PrintArea.js"></script>
    <script src="../public/js/toastr.js"></script>

    <!-- Bootstrap 3.3.5 -->
    <script src="../public/js/bootstrap.min.js"></script>
    
    <!-- AdminLTE App -->
    <script src="../public/js/app.min.js"></script>

    <!-- DATATABLES -->
    <script src="../public/datatables/jquery.dataTables.min.js"></script>    
    <script src="../public/datatables/dataTables.buttons.min.js"></script>
    <script src="../public/datatables/buttons.html5.min.js"></script>
    <script src="../public/datatables/buttons.colVis.min.js"></script>
    <script src="../public/datatables/jszip.min.js"></script>
    <script src="../public/datatables/pdfmake.min.js"></script>
    <script src="../public/datatables/vfs_fonts.js"></script> 

    <script src="../public/js/bootbox.min.js"></script> 
    <script src="../public/js/bootstrap-select.min.js"></script>  
    <script  type="text/javascript" src="../public/push/bin/push.min.js"></script> 

    <script src="../public/js/tinytools.tourtip.min.js"></script> 
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

  </body>



<a id="app-whatsapp" target="_blanck" href="https://api.whatsapp.com/send?phone=51966461459&text=Hola,%20estamos%20agradecidos%20que%20te%20contactes%20con%20nuestro%20equipo,%20podrías%20indicarnos%20tu%20consulta.">
     <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- <a id="app-messenger" target="_blanck" href="https://m.me/tecnologoperu">
    <i class="fa-brands fa-facebook-messenger"></i>
      </a>

      

   
    <div id="fb-root"></div>

   
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "103748057916903");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    Your SDK code
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v13.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script> -->



</html>
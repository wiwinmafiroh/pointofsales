

        </div>
        <!-- Akhir Pembungkus Bagian Navbar dan Content -->
    <!-- AKHIR BAGIAN NAVBAR DAN CONTENT -->
    <!-- AKHIR BAGIAN NAVBAR DAN CONTENT -->



    </div>
    <!-- AKHIR PEMBUNGKUS UTAMA -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.min.js"></script>
    <script type="text/javascript" src="../js/popper.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery-ui/jquery-ui.js"></script>
    <script type="text/javascript" src="../DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="../DataTables/media/js/jquery.js"></script>
    <script type="text/javascript" src="../DataTables/media/js/jquery.dataTables.js"></script>
    <script src="../DataTables/jquery.dataTables.js"></script>
    <script src="../DataTables/dataTables.bootstrap4.js"></script>
    <script src="../DataTables/dataTables.buttons.min.js"></script>
    <script src="../DataTables/vfs_fonts.js"></script>
    <script src="../DataTables/buttons.html5.min.js"></script>
    <script src="../DataTables/buttons.print.min.js"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- SCRIPT MENU PERKECIL -->
    <script type="text/javascript">
      
      // script untuk datatables
      $(document).ready( function () {
        $('#datatable').DataTable( {
          "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });
      } );      
      // script menu perkecil di dsahboard
      $(document).ready(function() {
        $('#sidebarcollapse').on('click', function() {
          $('#sidebar').toggleClass('active');
        });
      });


      // script untuk mencetak format mata uang
      $(document).ready(function() {
        $('.uang').mask('000.000.000', {reverse: true});
      });


      // format datepicker
      $(document ).ready(function(e) {
        $(".datepicker2").datepicker({
          dateFormat : 'yy-mm-dd'
        });
      });

    </script>
  </body>
</html>
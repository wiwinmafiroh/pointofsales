

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



      // JAVASCRIPT UNTUK MENU TRANSAKSI
      // JAVASCRIPT UNTUK MENU TRANSAKSI
      // JAVASCRIPT UNTUK MENU TRANSAKSI
      $(document).ready(function() {

        // untuk format number
        function formatNumber(num) {
          return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }


        // pilih produk dan tampilkan di pilih menu
        $(document).on("click", ".modal-pilih-menu", function() {

          var id    = $(this).attr('id'); // ambil nilai atributnya ketika meng click item dengan jQuery
          var kode  = $('#kode_' + id).val(); // ambil nilai atributnya ketika meng click item dengan jQuery
          var nama  = $('#nama_' + id).val(); // ambil nilai atributnya ketika meng click item dengan jQuery
          var harga = $('#hargajual_' + id).val(); // ambil nilai atributnya ketika meng click item dengan jQuery

          $('#tambahkan_id').val(id);
          $('#tambahkan_kode').val(kode);
          $('#tambahkan_nama').val(nama);
          $('#tambahkan_harga').val(harga); 
          $('#tambahkan_quantity').val(1);
          $('#tambahkan_total_harga_peritem').val(harga);

        });


        // ubah quantity menu yang dipilih di pilih menu
        $(document).on("change keyup", "#tambahkan_quantity", function() {

          var harga   = $('#tambahkan_harga').val();
          var quantity= $('#tambahkan_quantity').val();
          var total_harga_peritem = harga * quantity;

        $('#tambahkan_total_harga_peritem').val(total_harga_peritem);
        });


        // tombol tambahkan menu ke daftar pembelian
        $('body').on('click', '#tombol-tambahkan', function() {

          var id      = $('#tambahkan_id').val();
          var kode    = $('#tambahkan_kode').val();
          var nama    = $('#tambahkan_nama').val();
          var harga   = $('#tambahkan_harga').val();
          var quantity= $('#tambahkan_quantity').val();
          var total_harga_peritem = $('#tambahkan_total_harga_peritem').val();

          if ( id.length == 0 ) {
            alert("Menu Belum Dipilih !");
          } else if ( kode.length == 0 ) {
            alert("Kode Menu Harus Diisi !");
          } else if ( quantity == 0 ) {
            alert("Pembelian Menu Minimah Harus 1");
          } else {
              var table_pembelian = 
              "<tr id='tr_" + id + "'>" +

                "<td align='center' style='background-color: #F5DEB3' > <input type='hidden' name='menu[]' value='" + id + 
                "'> <input type='hidden' name='harga[]' value='" + harga + 
                "'> <input type='hidden' name='quantity[]' value='" + quantity + 
                "'> <input type='hidden' name='total_transaksi[]' value='" + total_harga_peritem + 
                "'>" + kode +
                "</td>" +

                "<td  style='background-color: #F5DEB3'>" + nama + "</td>" +
                "<td align='right'  style='background-color: #F5DEB3'>Rp " + formatNumber(harga) + ",</td>" +
                "<td align='center'  style='background-color: #F5DEB3'>" + formatNumber(quantity) + "</td>" +
                "<td align='right'  style='background-color: #F5DEB3'>Rp " + formatNumber(total_harga_peritem) + ",</td>" +
                "<td align='center'  style='background-color: #F5DEB3'> <span class='btn btn-sm btn-danger tombol-hapus-penjualan' total_harga_peritem='" + total_harga_peritem + 
                    "' quantity='" + quantity + 
                    "' harga='" + harga + 
                    "' id='" + id + 
                    "'><i class='fa fa-close'></i> Batal</span></td>" +

              "</tr>";

              $("#table-pembelian tbody").append(table_pembelian);


                // update total pembelian
                var pembelian_harga             = $('.pembelian_harga').attr('id');
                var pembelian_quantity          = $('.pembelian_quantity').attr('id');
                var pembelian_total_keseluruhan = $('.pembelian_total_keseluruhan').attr('id');

                // jumlahkan pembelian
                var jumlahkan_harga     = eval(pembelian_harga) + eval(harga);
                var jumlahkan_quantity  = eval(pembelian_quantity) + eval(quantity);
                var jumlahkan_total_keseluruhan = eval(pembelian_total_keseluruhan) + eval(total_harga_peritem);

                // isi di table penjualan
                $('.pembelian_harga').attr('id', jumlahkan_harga);
                $('.pembelian_quantity').attr('id', jumlahkan_quantity);
                $('.pembelian_total_keseluruhan').attr('id', jumlahkan_total_keseluruhan);

                // tulis di table penjualan
                $('.pembelian_harga').text('Rp ' + formatNumber(jumlahkan_harga) + ',');
                $('.pembelian_quantity').text(formatNumber(jumlahkan_quantity));
                $('.pembelian_total_keseluruhan').text('Rp ' + formatNumber(jumlahkan_total_keseluruhan) + ',');

                // total ditaro di PEMBAYARAN
                $('.total_pembelian').text('Rp ' + formatNumber(jumlahkan_total_keseluruhan) + ',');
                $('.sub_total_pembelian').text('Rp ' + formatNumber(jumlahkan_total_keseluruhan) + ',');
                $('.total_pembelian').attr('id',jumlahkan_total_keseluruhan);
                $('.sub_total_pembelian').attr('id',jumlahkan_total_keseluruhan);

                $('.total_akhir_form').val(jumlahkan_total_keseluruhan);
                $('.sub_total_akhir_form').val(jumlahkan_total_keseluruhan);

                // kosongkan
                $("#tambahkan_id").val("");
                $("#tambahkan_kode").val("");
                $("#tambahkan_nama").val("");
                $("#tambahkan_harga").val("");
                $("#tambahkan_quantity").val("");
                $("#tambahkan_total_harga_peritem").val("");
          }

        });


        // tombol untuk menghapus penjualan di daftar pembelian
        $("body").on("click", ".tombol-hapus-penjualan", function() {

          var id       = $(this).attr("id");
          var harga    = $(this).attr("harga");
          var quantity = $(this).attr("quantity");
          var total_harga_peritem   = $(this).attr("total_harga_peritem");

            // update total pembelian
            var pembelian_harga             = $('.pembelian_harga').attr('id');
            var pembelian_quantity          = $('.pembelian_quantity').attr('id');
            var pembelian_total_keseluruhan = $('.pembelian_total_keseluruhan').attr('id');

            // jumlahkan pembelian
            var kurangi_harga     = eval(pembelian_harga) - eval(harga);
            var kurangi_quantity  = eval(pembelian_quantity) - eval(quantity);
            var kurangi_total_keseluruhan = eval(pembelian_total_keseluruhan) - eval(total_harga_peritem);

            // isi di table pembelian
            $('.pembelian_harga').attr('id', kurangi_harga);
            $('.pembelian_quantity').attr('id', kurangi_quantity);
            $('.pembelian_total_keseluruhan').attr('id', kurangi_total_keseluruhan);

            // tulis di table pembelian
            $('.pembelian_harga').text('Rp ' + formatNumber(kurangi_harga) + ',-');
            $('.pembelian_quantity').text(formatNumber(kurangi_quantity));
            $('.pembelian_total_keseluruhan').text('Rp ' + formatNumber(kurangi_total_keseluruhan) + ',-');      

            // total ditaro di PEMBAYARAN
            $('.total_pembelian').text('Rp ' + formatNumber(kurangi_total_keseluruhan) + ',-');
            $('.sub_total_pembelian').text('Rp ' + formatNumber(kurangi_total_keseluruhan) + ',-');
            $('.total_pembelian').attr('id',kurangi_total_keseluruhan);
            $('.sub_total_pembelian').attr('id',kurangi_total_keseluruhan);

            $('.total_akhir_form').val(kurangi_total_keseluruhan);
            $('.sub_total_akhir_form').val(kurangi_total_keseluruhan);

            $("#tr_" + id ).remove();

        });


        //diskon, bayar dan kembali
        $("body").on("click keyup mouseenter change", ".total_diskon", function() {

          var diskon = $(this).val();

          if(diskon.length != 0 && diskon != "") {

            var sub_total = $(".sub_total_pembelian").attr("id");
            var total     = $(".total_pembelian").attr("id");

            var hasil_diskon  = sub_total * diskon / 100;
            var hasil2        = sub_total - hasil_diskon;
            $(".total_pembelian").text("Rp "+formatNumber(hasil2)+",");
            $(".total_akhir_form").val(hasil2);


              // bayar dan kembali
              $("body").on("input change", ".total_bayar", function() {

                var bayar = $(this).val();
                var kembali           = $(".total_kembali").attr("id");
                var hasil_bayar       = bayar - hasil2;

                $(".total_kembali").text("Rp " + formatNumber(hasil_bayar)+",");
                $(".kembali_form").val(hasil_bayar);

              });


          }else {

            var sub_total_pembelian = $(".sub_total_pembelian").attr("id");

            $(".total_pembelian").attr("id",sub_total_pembelian);
            $(".total_pembelian").text("Rp "+formatNumber(sub_total_pembelian)+",");

          }

        });



      });
    


    </script>
  </body>
</html>
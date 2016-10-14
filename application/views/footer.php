        <div class="modal fade" id="msg_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                        <h4 class="modal-title" id="title_modal"></h4>
                    </div>
                    <div class="modal-body">
                        <span id="mensagem_modal"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- jQuery 2.2.3 -->
        <script src="<?=base_url('scripts/plugins/jQuery/jquery-2.2.3.min.js')?>"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?=base_url('scripts/lib/bootstrap/js/bootstrap.min.js')?>"></script>
        <!-- iCheck -->
        <script src="<?=base_url('scripts/plugins/iCheck/icheck.min.js')?>"></script>

        <script>
          $(function () {
            $('input').iCheck({
              checkboxClass: 'icheckbox_square-blue',
              radioClass: 'iradio_square-blue',
              increaseArea: '20%' // optional
            });
          });
        </script>

    </body>

</html>
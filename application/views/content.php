<style>
      .content-wrapper{
            padding-left: 20px;
            padding-right: 20px;
      }
      .content-wrapper h2{
            margin-left:20px;
      }
</style>
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" id="content">
       
      <div class="row">

            <h2>Inicio</h2>
            <div class="col-sm-4">
                  <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-money fa-3" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Operaciones</span>
                        <span class="info-box-number"><a href="#" class="view_link" data-controller="operation" data-method="index" data-action="Add-Edit-Del-View-" >Ingresar</a></span>
                        </div>
                        <!-- /.info-box-content -->
                  </div>
            </div>
            <div class="col-sm-4">
                  <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-fw fa-user-secret fa-3" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Emisores</span>
                        <span class="info-box-number"><a href="#" class="view_link" data-controller="agent" data-method="emisor_list" data-action="Add-Edit-Del-View-" >Ingresar</a></span>
                        </div>
                        <!-- /.info-box-content -->
                  </div>
            </div>
            <div class="col-sm-4">
                  <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-money fa-3" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Tomadores</span>
                        <span class="info-box-number"><a href="#" class="view_link" data-controller="agent" data-method="tenedor_list" data-action="Add-Edit-Del-View-">Ingresar</a></span>
                        </div>
                        <!-- /.info-box-content -->
                  </div>
            </div>
      </div>

      <div class="row hidden">
            <div class="col-sm-4">
                  <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-money fa-3" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Operaciones</span>
                        <span class="info-box-number">90<small>%</small></span>
                        </div>
                        <!-- /.info-box-content -->
                  </div>
            </div>
            <div class="col-sm-4">
                  <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-fw fa-user-secret fa-3" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Emisores</span>
                        <span class="info-box-number">90<small>%</small></span>
                        </div>
                        <!-- /.info-box-content -->
                  </div>
            </div>
            <div class="col-sm-4">
                  <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-money fa-3" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Tomadores</span>
                        <span class="info-box-number">90<small>%</small></span>
                        </div>
                        <!-- /.info-box-content -->
                  </div>
            </div>
      </div>

      </div><!-- /.content-wrapper -->

<?php $this->load->view('buscadores/banks'); ?>
<?php $this->load->view('buscadores/agents'); ?>
<!--
<div w3-include-html="<?php  echo base_url();?>application/views/buscadores/banks.php"></div>
<script>w3.includeHTML();</script>
-->

<script>
      $(function(){
            $(".view_link").click(function(){
                  console.debug("asdsada");
                  WaitingOpen();
                  $('#content').empty();
                  var controller=$(this).data('controller');
                  var method=$(this).data('method');
                  var action=$(this).data('action');
                  $.ajax({
                        type: 'POST',
                        //data: null,
                        //url: '<?php echo base_url(); ?>index.php/'+controller+'/'+metodh+'/'+actions,
                        url: '<?php echo base_url(); ?>index.php/'+controller+'/'+method+'/'+action,
                        success: function(result){
                                    WaitingClose();
                                    $("#content").html(result);
                              },
                        error: function(result){
                              WaitingClose();
                              ProcesarError(result.responseText, 'modalOper');
                        },
                        dataType: 'json'
                  });
                  

                  return false;
            });

      });

/*
function cargarView(controller, metodh, actions)
      {
        WaitingOpen();
        $('#content').empty();

        $.ajax({
            type: 'POST',
            //data: null,
            //url: '<?php echo base_url(); ?>index.php/'+controller+'/'+metodh+'/'+actions,
            url: '<?php echo base_url(); ?>index.php/'+controller+'/'+metodh+'/'+actions,
            success: function(result){
                          WaitingClose();
                          $("#content").html(result);
                  },
            error: function(result){
                  WaitingClose();
                  ProcesarError(result.responseText, 'modalOper');
                },
                dataType: 'json'
            });
      }
      */
      </script>
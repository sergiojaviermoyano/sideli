<form class="form-horizontal ope_form" action="">
   <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
        <div class="form-group">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
           <h3>Emisor</h3>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4  col-xs-12">
            <label class="">CUIT : </label>
            <input type="text" class="form-control" id="operationEmisorCuit" name="agente_emisor_id" />
            
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4  col-xs-12">
            <label class="">Nombre : </label>
            <input type="text" class="form-control" id="operationEmisorNombre" name="emisor_nombre" />
            
        </div> 
        <div class="col-lg-3 col-md-3 col-sm-4  col-xs-12">
            <label class="">Apellido : </label>
            <input type="text" class="form-control" id="operationEmisorApellido" name="emisor_apellido" />
            
        </div> 
        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 pull-right">
            <label class=""> </label>
            <button type="button" class="btn btn-success btn-block">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button> 
        </div>
    </div>        
    <hr>
    
    <div class="form-group">
        <div class="col-lg-2">
           <h3>Cheque</h3>
        </div>
        <div class="col-lg-3">
            <label class="">Nro : </label>
            <input type="text" class="form-control" id="operationChequeNro" name="nro_cheque" />
            
        </div>
        <div class="col-lg-3">
            <label class="">Banco: </label>
            <input type="text" class="form-control" id="operationBanco" name="banco_id" />
            
        </div> 
        <div class="col-lg-3">
            <label class="">Importe : </label>
            <input type="numeric" class="form-control" id="operationImporte" name="importe" />
            
        </div> 
    </div>                
    <hr>
    
    <div class="form-group">
        <div class="col-lg-2">
           <h3>Tomador</h3>
        </div>
        <div class="col-lg-3">
            <label class="">CUIT : </label>
                <input type="text" class="form-control" id="operationTomadorCuit" name="tomador_cuit" />
            
        </div>
        <div class="col-lg-3">
            <label class="">Nombre : </label>
                <input type="text" class="form-control" id="operationTomadorNombre" name="tomador_nombre" />
            
        </div> 
        <div class="col-lg-3">
        <label class="">Apellido : </label>
                <input type="text" class="form-control" id="operationTomadorApellido" name="tomador_apellido" />
            
        </div> 
         <div class="col-lg-1 pull-right">
            <label class=""> </label>
            <button type="button" class="btn btn-success btn-block">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button> 
        </div>
    </div>
          <hr>
    <div class="form-group">
        
        <div>
            <div class="col-lg-2">
            <h3>Plazo</h3>
        </div>
            <div class="col-lg-2">
                <label class="">Vencimiento : </label>
                <input type="text" class="form-control" id="" name="" />
            </div>
            <div class="col-lg-2">
                    <label class="">Dias: </label>
                    <input type="text" class="form-control" id="" name="" />
            </div> 
        
        </div>
        
        <div>
            <div class="col-lg-2 text-right">
                <h3>Tasas</h3>
            </div>
            <div class="col-lg-1">
                <label class="">Mensual : </label>
                <input type="text" class="form-control" id="" name="" />
            </div>
            <div class="col-lg-1">
                <label class="">Anual: </label>
                <input type="text" class="form-control" id="" name="" />
            </div> 
        
        </div>
        
    </div>      
   <hr>
   <div class="form-group">
        
        <div>
            <div class="col-lg-2">
            <h3>Intereses</h3>
        </div>
            <div class="col-lg-1">
                <label class="">Cliente : </label>
                <input type="text" class="form-control" id="" name="" />
            </div>
            
        
        </div>        
        
        <div class="">
            <div class="col-lg-1 text-right">
                <h3>Comisión:</h3>
            </div>
            <div class="col-xs-1 text-center">
                <label class="">% : </label>
                <input type="text" class="form-control" id="" name="" />
            </div>
            <div class="col-lg-1 ">
                <label class="">$: </label>
                <input type="text" class="form-control" id="" name="" />
            </div> 
        
        </div>

        <div class="">
            <div class="col-lg-2 text-right">
                <h3>Neto:</h3>
            </div>
            <div class="col-xs-2">
                <label class="">$ : </label>
                <input type="text" class="form-control" id="" name="" />
            </div>
            
        
        </div>
        
    </div>      
   <hr>
    <div class="form-group">
        <div class="col-lg-2 ">
            <h3>Cobros Varios</h3>
        </div>
        <div class="col-lg-2">
            <label class="">Impuesto Cheque: </label>
            <input type="text" class="form-control" id="" name="" />
        </div>

        <div class="col-lg-2">
            <label class="">Gastos: </label>
            <input type="text" class="form-control" id="" name="" />
        </div>
        <div class="col-lg-2 text-right">
            <h3></h3>
        </div>
        <div class="col-lg-1 ">
            <label class="">IVA: </label>
            <input type="text" class="form-control" id="" name="" />
        </div>
        <div class="col-lg-1 ">
            <label class="">Sellado: </label>
            <input type="text" class="form-control" id="" name="" />
        </div>        

    </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">Form 2</div>
    <div role="tabpanel" class="tab-pane" id="messages">Form 3</div>
    <div role="tabpanel" class="tab-pane" id="settings">Form 4</div>
  </div>
    
    
       
</form>
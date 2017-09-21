var emisorClass = {
    id:             -1,
    cuit:           '',
    nombre:         '',
    apellido:       '', 
    razon_social:   '',
    setEmisor:      function(id_, cuit_, nombre_, apellido_, razon_social_){
                        this.id             = id_;
                        this.cuit           = cuit_;
                        this.nombre         = nombre_;
                        this.apellido       = apellido_;
                        this.razon_social   = razon_social_;
                    }
};

var tomadorClass = {
    id:             -1,
    cuit:           '',
    nombre:         '',
    apellido:       '', 
    razon_social:   '',
    setTomador:      function(id_, cuit_, nombre_, apellido_, razon_social_){
                        this.id             = id_;
                        this.cuit           = cuit_;
                        this.nombre         = nombre_;
                        this.apellido       = apellido_;
                        this.razon_social   = razon_social_;
                    }
};

var bancoClass = {
    id:             -1,
    descripcion:    '',
    setBanco:       function(id_, descripcion_){
                        this.id             = id_;
                        this.descripcion    = descripcion_;
                    }
};

var chequeClass = {
    id:             -1,
    numero:         '',
    banco:          bancoClass,
    importe:        0,
    vencimiento:    '',
    dias:           0,
    setCheque:      function(id_, numero_, banco_, importe_, vencimiento_, dias_){
                        this.id             = id_;
                        this.numero         = numero_;
                        this.banco          = banco_;
                        this.importe        = importe_;
                        this.vencimiento    = vencimiento_;
                        this.dias           = dias_;
                    }
};

var operationClass = {
    emisor:         emisorClass,
    tomador:        tomadorClass,
    cheque:         chequeClass,
    tasaM:          0,
    tasaA:          0,
    interesCliente: 0,
    comisionPor:    0,
    comisionImp:    0,
    importeNeto:    0,
    impuestoCheque: 0,
    gastos:         0,
    importeIVA:     0,
    importeSellado: 0
};
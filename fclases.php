<?php
class datospersona
{
    public function __construct(
        protected $dcodigo,
        protected $dnombre,
        protected $ddireccion = null,
        protected $dtelresi = null,
        protected $dtelcel = null,
        protected $demail = null
    ) {
    }

   
    public function get_codigo() {
        return $this->dcodigo;
    }

    public function get_nombre() {
        return $this->dnombre;
    }

    public function get_direccion() {
        return $this->ddireccion;
    }

    public function get_telresi() {
        return $this->dtelresi;
    }

    public function get_telcel() {
        return $this->dtelcel;
    }

    public function get_demail() {
        return $this->demail;
    }

   
    public function set_nombre($dnombre) {
        $this->dnombre = $dnombre;
    }

    public function set_direccion($ddireccion) {
        $this->ddireccion = $ddireccion;
    }

    public function set_telresi($dtelresi) {
        $this->dtelresi = $dtelresi;
    }

    public function set_telcel($dtelcel) {
        $this->dtelcel = $dtelcel;
    }

    public function set_email($demail) {
        $this->demail = $demail;
    }
}
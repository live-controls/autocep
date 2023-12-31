<?php

namespace LiveControls\AutoCep\Http\Livewire;

use LiveControls\AutoCep\Scripts\GetCEP;
use Illuminate\Support\Facades\Log;
use LiveControls\Utils\Utils;
use Livewire\Component;

class AutoCep extends Component
{
    public $prefix = '';
    public $titlesuffix = '';
    public $oldmodel = null; //If this is set, it will try to read from this model (Needed for editing)

    public $required;

    public $cepvalue;
    public $cep = null;
    public $oldcep = null;
    public $street = '';
    public $area = '';
    public $uf = '';
    public $city = '';

    public $valid = -1;

    private bool $firststart = false;


    //CUSTOM FORM CONTROL NAMES
    public $areacodeName = 'areacode';
    public $streetName = 'street';
    public $numberName = 'housenumber';
    public $complementName = 'complement';
    public $areaName = 'area';
    public $cityName = 'city';
    public $ufName = 'uf';
    public $countryName = 'country';

    protected $listeners = [
        'cepUpdated' => 'fetchInfos'
    ];

    public function mount(){
        if(is_null($this->required))
        {
            $this->required = false;
        }
        if(!is_null($this->oldmodel))
        {
            $this->firststart = true;
            $this->cep = $this->oldmodel->{$this->prefix.$this->areacodeName};
            $this->cepvalue = $this->cep;
            $this->street = $this->oldmodel->{$this->prefix.$this->streetName};
            $this->area = $this->oldmodel->{$this->prefix.$this->areaName};
            $this->uf = $this->oldmodel->{$this->prefix.$this->ufName};
            $this->city = $this->oldmodel->{$this->prefix.$this->cityName};
        }
    }

    public function render()
    {
        if(is_numeric($this->cep) && $this->firststart == false && $this->cep != $this->oldcep)
        {
            $this->fetchInfos();
            $this->oldcep = $this->cep;
        }
        $this->firststart = false;
        return view('livecontrols-autocep::livewire.input');
    }

    public function updated($name, $value)
    {
        if($name == "cepvalue")
        {
            $this->emit($this->prefix.$this->areacodeName.'-valueUpdated', ['value' => $value]);
        }
    }

    public function checkInfos(): bool
    {
        return $this->cep == null || $this->cep == '' || !is_numeric($this->cep) ? false : Utils::countNumber($this->cep) == 8;
    }

    public function fetchInfos()
    {
        if(!$this->checkInfos())
        {
            return;
        }
        $this->valid = -1;
        $result = GetCEP::get($this->cep);
        if($result["statusText"] == 'ok')
        {
            $this->uf = array_key_exists('estado', $result) ? $result["estado"]["sigla"] : '';
            $this->city = array_key_exists('cidade', $result) ? $result["cidade"]["nome"] : '';
            $this->area = array_key_exists('bairro', $result) ? $result["bairro"] : '';
            $this->street = array_key_exists('logradouro', $result) ? $result["logradouro"] : '';
        }elseif($result["statusText"] == 'invalid')
        {
            $this->valid = 0;
        }elseif($result["statusText"] == 'no_connection')
        {
            Log::warning('Connection to CEP server couldnt be established!');
        }elseif($result["statusText"] == 'connection_error'){
            Log::warning('Connection error, probably wrong API Key or limit reached!');
        }else
        {
            Log::warning('Unknown error trying to get CEP!');
        }
    }
}

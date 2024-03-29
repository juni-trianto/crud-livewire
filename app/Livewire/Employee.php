<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    public $paginationTheme = 'bootstrap';
    public $nama;
    public $email;
    public $alamat;
    public $updateData = false;
    public $employee_id;
    public $katakunci;
    public $employee__selected_id = [];

    public function store(){

        // VALIDASI FORM DATA
       $rules = [
        'nama' => 'required',
        'email' => 'required|email',
        'alamat' => 'required',
       ];
    //    MERUBAH PESAN ERROR
       $pesan = [
        'nama.required' => 'Nama Wajib diisi',
        'email.required' => 'Email Wajib diisi',
        'email.email' => 'Format  email tidak sesuai',
        'alamat.required' => 'Email Wajib diisi',
       ];
    //    VALIDASU

       $validated = $this->validate($rules, $pesan);
    //    SIMPAN KE DATABASE
       ModelsEmployee::create($validated);
    //    SESSION FLASH DATA
       session()->flash('message', 'data berhasil disimpan');
    //    FORM DI KOSONGKAN JIKA SUDAH TERSIMPAN
     $this->clear();
    }

    public function clear(){
        $this->nama = '';
        $this->email = '';
        $this->alamat = '';
        $this->updateData = false;
        $this->employee_id = '';
        $this->employee__selected_id = [];
    }

    public function delete(){
        $id = $this->employee_id;
        if($id != ''){
           ModelsEmployee::find($id)->delete();
        }
        if(count($this->employee__selected_id)){
         for ($i=0; $i < count($this->employee__selected_id) ; $i++) { 
             ModelsEmployee::find($this->employee__selected_id[$i])->delete();
         }
        }
       $this->clear();
       session()->flash('message', 'data berhasil di-delete');

    }

    public function delete_confirmation($id){

        if($id != '')
        {
           $this->employee_id = $id;
        }
    }

    public function update(){

        // VALIDASI FORM DATA
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
           ];
        //    MERUBAH PESAN ERROR
           $pesan = [
            'nama.required' => 'Nama Wajib diisi',
            'email.required' => 'Email Wajib diisi',
            'email.email' => 'Format  email tidak sesuai',
            'alamat.required' => 'Email Wajib diisi',
           ];
        //    VALIDASU
           $validated = $this->validate($rules, $pesan);
        //    UPDATE KE DATABASE
          $data = ModelsEmployee::find($this->employee_id);
          $data->update($validated);
        //    SESSION FLASH DATA
           session()->flash('message', 'data berhasil diupdate');
        //    FORM DI KOSONGKAN JIKA SUDAH TERSIMPAN
         $this->clear();
    }

    public function edit($id){
        $data = ModelsEmployee::find($id);
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->alamat = $data->alamat;
        $this->employee_id = $id;
        $this->updateData = true;
    }

    public function render()
    {
      if($this->katakunci != null)
      {
         $data = ModelsEmployee::where('nama', 'like','%'.$this->katakunci .'%' )->orWhere('alamat', 'like', '%'. $this->katakunci .'%')->orderBy('nama', 'asc')->paginate(2);
      }else{
         $data = ModelsEmployee::orderBy('nama', 'asc')->paginate(2);
      }
        return view('livewire.employee', ['dataEmployess' => $data ]);
    }
}

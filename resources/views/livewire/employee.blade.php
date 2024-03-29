<div class="container">
        <!-- START FORM -->
        @if ($errors->any())
            <div class="pt-3">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if (session()->has('message'))
            <div class="pt-3">
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <form>
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="nama" >
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" wire:model="email">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="alamat">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        @if ($updateData == false)
                        <button type="button" class="btn btn-primary"  wire:click="store()" name="submit">SIMPAN</button>
                        @else
                        <button type="button" class="btn btn-primary"  wire:click="update()" name="submit">UPDATE</button>
                        @endif
                        <button type="button" class="btn btn-warning"  wire:click="clear()" name="submit">CLEAR</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- AKHIR FORM -->

        <!-- START DATA -->
        <h1>Data Pegawai</h1>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <div class="pb-3 pt-3">
                <input type="text" class="form-control mb-3 w-25" placeholder="Search... " wire:model.live="katakunci">
            </div>
            @if (count($employee__selected_id))
            <a wire:click="delete_confirmation('')" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-danger btn-sm">
                Del {{ count($employee__selected_id)}} Data
            </a>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th class="col-md-1">No</th>
                        <th class="col-md-4">Nama</th>
                        <th class="col-md-3">Email</th>
                        <th class="col-md-2">Alamat</th>
                        <th class="col-md-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataEmployess as $key => $value )
                    <tr>
                        <td><input type="checkbox" wire:key="{{$value->id}}" value="{{$value->id}}" wire:model.live="employee__selected_id"></td>
                        <td>{{ $dataEmployess->firstItem() + $key  }}</td>
                        <td>{{ $value->nama }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->alamat }}</td>
                        <td>
                            <a wire:click="edit({{$value->id}})" class="btn btn-warning btn-sm">Edit</a>
                            <a wire:click="delete_confirmation({{$value->id}})" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-danger btn-sm">Del</a>
                        </td>
                    </tr>
                    @endforeach;
                </tbody>
            </table>
            {{$dataEmployess->links()}}

        </div>
        <!-- AKHIR DATA -->
            <!-- Modal -->
            <div wire:ignore.self class="modal fade"  id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    Yakin akan menghapus data ini!
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="clear()" data-bs-dismiss="modal">Tidak</button>
                    <button type="button " wire:click="delete()" class="btn btn-primary"  data-bs-dismiss="modal">Ya</button>
                    </div>
                </div>
                </div>
            </div>
        {{-- END MODAL --}}
    </div>
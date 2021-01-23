@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
@stop

@section('content')
    <div class="card">
        <div class="card-header text-dark"><h2>Productos</h2>
            <p><button type="button" class="btn btn-secondary" id="btnAdd"><i class="fa fa-plus"></i> Registrar</button></p>
        </div>

        <div class="card-body">
            <table class="table display responsive nowrap" id="tb_data" style="width: 100%">
                <thead>
                <tr class="bg-warning text-white">
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Operaciones</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" role="dialog" tabindex="-1" id="mdlform">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 id="modal-title" class="modal-title">Nuevo producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form" name="form">
                        <input type="hidden" id="id" name="id">


                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="name">Nombre</label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                              <label for="">Descripción</label>
                              <textarea class="form-control" id="description" name="description" rows="4" placeholder="Descripción"></textarea>
                            </div>
                            <div class="form-group">
                              <label for="name">Precio</label>
                              <input type="number" class="form-control" id="price" name="price" placeholder="Precio">
                            </div>
                            
                            
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="name">Stock</label>
                              <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock" value="0" readonly>
                            </div>
                            <div class="form-group">
                              <label for="name">Vencimiento</label>
                              <input type="date" class="form-control" id="expiration" name="expiration" placeholder="Vencimiento">
                            </div>
                            <div class="form-group">
                              <label for="abbreviation">Categoria</label>
                              <select class="form-control" name="category_id" id="category_id" required>
                                  @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                  @endforeach
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="abbreviation">Estado</label>
                              <select class="form-control" name="state" id="state" required>
                                  <option value="1" selected>Activo</option>
                                  <option value="0">Inactivo</option>
                              </select>
                            </div>
                          </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button type="button" class="btn btn-primary" id="btnSave">GRABAR</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
@stop
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script> console.log('Hi!'); </script>
    <script>

        $('#btnAdd').click(function() {
            clearinput();
            $('#modal-title').html('Nuevo producto');
            $('#id').val('');
            $('#name').val('');
            $('#description').val('');
            $('#price').val('');
            $('#expiration').val('');
            $('#stock').val(0);
            $('#category_id').val(1);
            $('#state').val(1);
            $('#mdlform').modal('show');
        });
    
        let tb_data = $('#tb_data').DataTable({
            'order': [[1, 'desc']],
            'processing': false,
            'serverSide': true,
            'responsive': true,
            'ajax': {
                'url': '{{route('dtproducts')}}',
                'type' : 'get',
            },
            'language': {
                'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
            },
            'columns': [
                {data: 'name'},
                {data: 'category.name'},
                {data: 'price'},
                {data: 'stock'},
                {
                    data: 'state',
                    render: function(data){
                        if(data == 0)
                            return '<span class="badge badge-danger">Inactivo</span>';
                        else
                            return '<span class="badge badge-success">Activo</span>';
                    },
                },
                {data: null}
            ],
            'fnRowCallback': function(nRow, aData) {
                let button = '';
                button += '<button type="button" class="btn btn-secondary btn-xs edit"><i class="fa fa-edit"></i></button> &nbsp; &nbsp;';
                button += '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></button>';
                //console.log(aData, 'Datos');
                $(nRow).find('td:eq(5)').html(button);
            }
        });

        $('#btnSave').click(function() {
            if(validate_data() == false)
                return false;
            let data = $('#form').serialize();
            
            $.ajax({
                url: '{{route('saveproducts')}}',
                type: 'post',
                data: data + '&_token=' + '{{ csrf_token() }}',
                'success': function(response) {
                    if(response == true)
                        toastr.success('Se grabó satisfactoramente');
                    else
                        toastr.error('Se ha producido un error');
                    tb_data.ajax.reload();
                    $('#mdlform').modal('hide');
                }
            });
        });

        $('body').on('click', '.delete', function() {
            let data = tb_data.row( $(this).parents('tr') ).data();

            $.ajax({
                    url: 'deleteproducts/' + data['id'],
                    type: 'get',
                    'success': function(response) {
                        if(response == true)
                            toastr.success('Se elimino satisfactoramente el registro');    
                        else
                            toastr.error('Ha ocurrido un error :(');
                        tb_data.ajax.reload();
                    }
            });
        });

        $('body').on('click', '.edit', function() {
            clearinput();
            $('#modal-title').html('Editar producto');

            let data = tb_data.row( $(this).parents('tr') ).data();
            $('#id').val(data['id']);
            $('#name').val(data['name']);
            $('#description').val(data['description']);
            $('#price').val(data['price']);
            $('#stock').val(data['stock']);
            $('#expiration').val(data['expiration']);
            $('#category_id').val(data['category_id']);
            $('#state').val(data['state']);
            $('#mdlform').modal('show');
        });

        function validate_data(){
            clearinput();
            if($('#name').val() == ''){
                $('#name').addClass("is-invalid");
                return false;
            }
            return true;
        }

        function clearinput(){
            $('#name').removeClass('is-invalid');
            $('#description').removeClass('is-invalid');
        }
    </script>
@stop

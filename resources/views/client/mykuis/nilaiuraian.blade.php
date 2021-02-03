@extends('layouts.new_layouts.master')
@section('head')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.min.css') }}">
@endsection

@section('content')
    <div class="content">
        @if (Session::has('pesan-bahaya'))
        <div class="alert alert-danger text-bold">{{ Session::get('pesan-bahaya') }}</div>                
        @endif
        @if (Session::has('pesan-peringatan'))
                <div class="alert alert-warning text-bold">{{ Session::get('pesan-peringatan') }}</div>                
        @endif
        @if (Session::has('pesan-info'))
            <div class="alert alert-info text-bold">{{ Session::get('pesan-info') }}</div>
        @endif
        <div class="w3l-homeblock2 w3l-homeblock6 py-5">
            <div class="container-fluid px-sm-5 py-lg-5 py-md-4">
                <div class="row">
                    <div class="col-lg-6" style="margin-bottom: 50px">
                        <div class="bg-clr-white" style="min-height: 270px">
                            <div class="row">                        
                                <div class="col-sm-12 card-body blog-details align-self">
                                    <div class="pad" style="margin-left: 10%">
                                        <p class="blog-desc jam text-bold" id="jam" ></p>
                                        <a class="blog-desc waktu" id="waktu"> </a>                                
                                    </div>                            
                                    <div class="author mt-3" style="margin-left: 10%">
                                        <img 
                                            @if (auth()->user()->profile->photo==null)
                                                src="{{ asset('assets/assets/images/a1.jpg') }}"
                                            @else
                                            src="{{ asset('photo/'.auth()->user()->profile->photo) }}"
                                            @endif alt="" class="img-fluid rounded-circle">
                                        <ul class="blog-meta">
                                            <li>
                                                <a >{{ auth()->user()->name }}</a> 
                                            </li>
                                            <li class="meta-item blog-lesson">
                                                <p>{{ auth()->user()->role }} </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-clr-white" style="min-height: 270px">
                            <div class="col-sm-12 card-body blog-details align-self">
                                <div class="pad" style="margin-left: 10%">
                                    
                                    <div class="form-group text-muted">
                                        <label for="">URAIAN SOAL</label>
                                        <h3>{{ $uraians->uraian->judul }} <br> 
                                            <?php $hasil = App\Nilai::where('profile_id',$uraians->profile->id)->where('uraian_id',$uraians->uraian->id)->first()?>
                                            @if ($hasil==null)
                                            <p class="badge badge-danger btn text-white" data-toggle="modal" data-target="#modal-fromleft-nilai" data-uraian="{{ $uraians->uraian->id }}" data-profile="{{ $uraians->profile->id }}">BELUM DINILAI</p>
                                            @else
                                            <p class="badge badge-primary btn text-white" data-toggle="modal" data-target="#modal-fromleft-nilai" data-id="{{ $hasil->id }}" data-uraian="{{ $uraians->uraian->id }}" data-profile="{{ $uraians->profile->id }}">NILAI : {{ $hasil->nilai }}</p>
                                            @endif
                                        </h3>
                                        <label for="">SISWA</label>
                                        <h3>{{  $uraians->profile->user->name  }}<h3>
                                    </div>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- table --}}
                <div class="card bg-clr-white" style="padding: 5%; margin-top: 50px">
                    
                    <div class="form-group">
                        <label for=""> URAIAN SOAL </label>
                        <p>{!! $uraians->uraian->soal !!}</p>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="">JAWABAN : {{ $uraians->profile->user->name }}</label>
                        <p>{!! $uraians->jawabanku !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-fromleft-nilai" tabindex="-1" role="dialog" aria-labelledby="modal-fromleft" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">                            
            <div class="modal-content">
                <form id="form-tambah-quiz" name="form-tambah-quiz" class="form-horizontal" action="{{ route('berinilai') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-success">
                            <h3 class="block-title">NILAI</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>                    
                        <div class="block-content">                            
                            <div class="form-group">                            
                                <div class="block-content text-center">
                                    <p>BERIKAN NILAI </p>
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="profile_id" id="profile_id">
                                    <input type="hidden" name="uraian_id" id="uraian_id">
                                    <input type="number" min="0" max="100" name="nilai" class="form-control" required>
                                </div>
                            </div>                        
                            <div class="form-group float-right">
                                <div class="block-content">
                                    <button type="submit" class="btn btn-outline-success">UPLOAD NILAi</button>
                                </div>
                            </div>                        
                        </div>                                                             
                    </div>                        
                </form>                   
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $('#modal-fromleft-nilai').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget) 
    var id = button.data('id')
    var profile = button.data('profile')
    var uraian = button.data('uraian') 
    var modal = $(this)
    modal.find('.block-title').text('RESET HASIL KUIS');   
    modal.find('.block-content #profile_id').val(profile);
    modal.find('.block-content #uraian_id').val(uraian);
    modal.find('.block-content #id').val(id);
});
</script>
@endsection
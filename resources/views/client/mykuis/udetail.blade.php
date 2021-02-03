@extends('layouts.new_layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="w3l-homeblock2 w3l-homeblock6 py-5">
    <div class="container-fluid px-sm-5 py-lg-5 py-md-4">
        <h3 class="section-title-left mb-4 text-uppercase"> Latihan Soal</h3>
        {{-- content header --}}
        @if (Session::has('pesan'))
        <div class="alert alert-info text-bold">{{ Session::get('pesan') }}</div>
        @endif
        @if (Session::has('pesan-peringatan'))
            <div class="alert alert-warning text-bold">{{ Session::get('pesan-peringatan') }}</div>
        @endif
        @if (Session::has('pesan-bahaya'))
            <div class="alert alert-danger text-bold">{{ Session::get('pesan-bahaya') }}</div>
        @endif
        @if (Session::has('pesan-sukses'))
            <div class="alert alert-info text-bold">{{ Session::get('pesan-info') }}</div>
        @endif                            
        <div class="row">                
            <div class="col-lg-6 mb-50">
                <div class="bg-clr-white">
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
                                        <span class="meta-value"> {{ auth()->user()->role }} </span>. <span class="meta-value ml-2"><span class="fa fa-check"></span></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-50">
                <div class="bg-clr-white" style="min-height: 232px; max-height: 232px">
                    <div class="row">                        
                        <div class="col-sm-12 card-body blog-details align-self">
                            <div class="pad" style="margin-left: 10%">
                                @if (auth()->user()->role=='instruktur')
                                    <p class="blog-desc"> Anda memiliki {{ count(auth()->user()->kursus) }} kursus sebagai berikut :</p>
                                    @foreach (auth()->user()->kursus as $item)
                                    <ul>
                                        <ol class="fa fa-check"> <a href="{{ route('myCourse',$item->slug) }}">{{ $item->mapel->mapel_name }} | {{ $item->kelas->kelas_name }}</a></ol>
                                    </ul>
                                    @endforeach
                                @elseif(auth()->user()->role=='siswa')
                                    <p class="blog-desc"> Anda memiliki {{ count(auth()->user()->profile->kursus) }} kursus sebagai berikut :</p>
                                    @foreach (auth()->user()->profile->kursus as $item)
                                    <ul>
                                        <ol class="fa fa-check"> <a href="{{ route('myCourse',$item->slug) }}">{{ $item->mapel->mapel_name }} | {{ $item->kelas->kelas_name }}</a></ol>
                                    </ul>
                                    @endforeach    
                                @else
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- table kuis --}}
    </div>
</div>
<div class="content">
    {{-- <div class="w3l-homeblock2 w3l-homeblock6 py-5" id="daftarakuis">
        <div class="container-fluid px-sm-5 py-lg-5 py-md-4"> --}}
            <div class="bg-clr-white" style="padding: 5%">
                <h3>URAIAN SOAl KATEGORI {{ $mapel->mapel_name }} {{ $kelas->kelas_name }} </h3>
                @if (auth()->user()->role=='siswa')
                    <div class="form-group">
                        <label for=""><u>JUDUL </u></label>
                        <h5>{{ $uraian->judul }}</h5>
                    </div>
                    <div class="form-group border-bottom">
                        <div class="row">
                            <div class="col-4 col-sm-4">
                                <label for=""><u>SOAL </u></label>
                            </div>
                            <div class="col-8 col-sm-8">
                                <label for=""><u>WAKTU : jam {{ $uraian->start }} - jam {{ $uraian->end }}</u> </label>
                            </div>
                            
                        </div>
                        <p>{!! $uraian->soal !!}</p>
                    </div>
                    <?php $jawab = App\Jawaburai::where('profile_id', auth()->user()->profile->id)->where('uraian_id',$uraian->id)->first()?>
                    @if ($jawab==null)
                    <form action="{{ route('uraianJawab') }}" method="POST" enctype="multipart/form-data">@csrf
                        <div class="form-group">
                            <input type="hidden" name="user_id" id="" value="{{ $uraian->user_id }}">
                            <input type="hidden" name="profile_id" id="" value="{{ auth()->user()->profile->id }}">
                            <input type="hidden" name="uraian_id" id="" value="{{ $uraian->id }}">
                            <label for="">JAWABAN </label>
                            <textarea name="jawabanku" class="form-control js-summernote" id="" cols="30" rows="10">masukan jawaban anda..</textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"> JAWAB</button>
                        </div>
                    </form>
                    @else
                        <label for=""><u> JAWABANKU </u></label>
                        <p>{!! $jawab->jawabanku !!}</p>
                        <?php $hasil = App\Nilai::where('profile_id', $jawab->profile_id)->where('uraian_id', $jawab->uraian_id)->first()?>
                        @if ($hasil==null)
                        <h2><p class="badge badge-danger"> BELUM DINILAI </p></h2>
                        @else
                        <h2> <p class="badge badge-primary"> NILAI : {{ $hasil->nilai }} </p></h2>
                        @endif
                    @endif
                    
                    
                @else
                    @if (auth()->user()->id==$uraian->user_id)
                    <form action="{{ route('uraianU') }}" method="POST" enctype="multipart/form-data">@csrf
                                
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ auth()->user()->id }}" required>
                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $uraian->id }}" required>
                                <input type="hidden" class="form-control" id="kelas_id" name="kelas_id" value="{{ $uraian->kelas->id }}">
                                <input type="hidden" class="form-control" id="mapel_id" name="mapel_id" value="{{ $uraian->mapel->id }}">
                            <label for="">JUDUL</label>
                            <input type="text" name="judul" value="{{ $uraian->judul }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">SOAL</label>
                            <textarea name="soal" class="js-summernote" id="" cols="30" rows="10">{{ $uraian->soal }}</textarea>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6 col-sm-6">
                                    <label for="">WAKTU MULAI</label>
                                    <input type="time" value="{{ $uraian->start }}" name="start" min="1" max="24" class="form-control" placeholder="jam 1-24" required>
                                </div>
                                <div class="col-6 col-sm-6">
                                    <label for="">WAKTU SELESAI</label>
                                    <input type="time" value="{{ $uraian->end }}" name="end" min="1" max="24" class="form-control" placeholder="Jam 1-24" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">STATUS</label>
                            <select name="status" id="" class="form-control">
                                <option value="1" @if($uraian->status=="1")selected @endif> SIAP</option>
                                <option value="0" @if($uraian->status=="0")selected @endif>BELUM SIAP</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class=" btn btn-primary"> UPDATE </button>
                        </div>
                    </form>
                    @else
                    <div class="form-group">
                        <label for=""><u> JUDUL </u></label>
                        <h5>{{ $uraian->judul }}</h5>
                    </div>
                    <div class="form-group">
                        <label for=""><u> SOAL </u></label>
                        <p>{!! $uraian->soal !!}</p>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6 col-sm-6">
                                <label for="">WAKTU MULAI</label>
                                <p type="number" value="" name="start" min="1" max="24"  placeholder="jam 1-24" required>{{ $uraian->start }}</p>
                            </div>
                            <div class="col-6 col-sm-6">
                                <label for="">WAKTU SELESAI</label>
                                <p type="number" value="{{ $uraian->end }}" name="end" min="1" max="24" placeholder="Jam 1-24" required>{{ $uraian->end }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
            </div>                
        {{-- </div>
    </div> --}}
</div>





@endsection

@section('script')

<script type="text/javascript">
    var months  =['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    var theDays =['Minggu','Senen','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    var date    = new Date();
    var day     = date.getDate();
    var month   = date.getMonth();
    var thisDay = date.getDay(),
        thisDay = theDays[thisDay];
    var yy      = date.getYear();
    var year    = (yy<1000) ? yy + 1900: yy;
    document.write(thisDay+',' + day + '' + months[month] + '' + year);
    document.getElementById("waktu").innerHTML=(thisDay+', ' + day + '' + months[month] + '' + year);
</script>
<script>
    function showtime()
    {            
        var today       = new Date();
        var curr_hour   = today.getHours();
        var curr_minute = today.getMinutes();
        var curr_second = today.getSeconds();            
        curr_hour       = checkTime(curr_hour);
        curr_minute     = checkTime(curr_minute);
        curr_second     = checkTime(curr_second);
        document.getElementById("jam").innerHTML=curr_hour+ ":" + curr_minute + ":" + curr_second ;                        
    }
    function checkTime(i){            
        if(i == 60){
            i = 60;
        }
        return i;        
    }
    setInterval(showtime, 500);
</script>
@endsection
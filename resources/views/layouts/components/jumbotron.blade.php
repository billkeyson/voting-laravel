<section class="jumbotron text-center p-5 mb-4">
    <div class="container">
        <h1 class="jumbotron-heading text-white text-center">{!! $title ?? "" !!}</h1>
        <p class="lead text-white"></p>
        <p>
            {{-- <nav c="breadcrumb"> --}}
        <ol class="breadcrumb">{{$desctiption  ??  ""}}
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            @foreach ($jumbotrons as $item)
            <li class="breadcrumb-item {{$loop->last? 'active':''}}" aria-current="page">{{$item}}</li>
            @endforeach
           
        </ol>
        {{-- </nav> --}}
        {{-- <a href="#" class="btn btn-primary my-2">Main call to action</a>
    <a href="#" class="btn btn-secondary my-2">Secondary action</a> --}}
        </p>
    </div>
</section>
<div class="row">
    @foreach ($data as $index => $item)
    <div class="col-sm-12 col-md-6 col-lg-4 mb-4" onclick="handleProduct('{{ route('public.product-booking', Crypt::encrypt($item->id)) }}')">
        <div class="card text-white card-has-bg click-col" style="background-image: url('{{ $item->image_url()}}');">
           <div class="card-img-overlay d-flex flex-column" style="background: linear-gradient(0deg,
			rgba(31, 49, 60, 0.379) 0%,
			#8662e8 160%)">
              <div class="card-body">
                <a target="_blank" href="https://www.google.com/maps?q={{ $item->studio->latitude.','.$item->studio->longitude }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{$item->studio->address}}" data-kt-initialized="1">
                    <p class="card-meta mb-1" style="color:#fecb6e;"><i class="fa-solid fa-location-dot" style="color:#fecb6e;"></i> {{$item->studio->name}} - {{$item->studio->city}}</p>
                </a>
                <h2 class="card-title mt-0">
                    <a class="text-white" href="#">{{$item->name}}</a>
                </h2>
              </div>
              <div class="card-footer">
                  <div class="media">
                      <small>Start From</small>
                      <h2 class="card-title mt-0" style="color: #01cecb">
                          Rp. @currency($item->price) / Sesi 
                      </h2>
                  </div>
              </div>
           </div>
        </div>
     </div>
    @endforeach

    <div class="row justify-content-center mt-3">
        <div class="col-auto">
            {{ $data->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>

@push('css')
    <link href="{{ asset('assets/css/custom-homepage.css') }}" rel="stylesheet" type="text/css" />
    <style>
        p.small.text-muted{
            display: none;
        }
    </style>
@endpush

@push('js')
    <script>
        function handleProduct(url)
        {
            window.location = url;
            return false;
        }
    </script>
@endpush
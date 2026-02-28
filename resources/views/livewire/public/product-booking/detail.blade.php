@push('css')
    <style>
      .select-time.times-checkbox-checked{
         background-color: #5d2fc2;
         border-color: #5d2fc2 !important;
         color:#fff;
      }
      .addon-checkbox.addon-checkbox-checked {
         border-color: #5d2fc2 !important;
      }
    </style>
@endpush
<div class="card-body pb-lg-0 position-relative">
   <form wire:submit="store">
      <a href="#" class="text-dark text-hover-primary fs-2 fw-bold">{{ $product_name }}</a>
      <a target="_blank" href="{{ $product_studio_location}}">
         <p class="card-meta text-muted mb-5 mb-xl-0 mb-md-0"><i class="fa-solid fa-location-dot text-muted"></i>{{ $product_studio_name }}</p>
      </a>
      <div class="d-flex flex-column flex-xl-row">
         <div class="flex-lg-row-fluid me-xl-15">
            <div class="mb-xl-17">
               <div class="mb-8">
                  <div class="overlay mt-5 d-flex justify-content-center align-items-center">
                     <!-- <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-350px" style="background-image:url('https://app.kuystudio.id/assets/uploads/product/2025-01/0fdf190248f2c384b5b6e7ac3f3885f32d6ce439.JPG')"></div> -->
                     <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded" style="background-image:url('{{ $product_image_url }}'); width: 300px; height: 300px;z-index: -1;"></div>
                  </div>
               </div>
               <p>Background yang tersedia di {{$product_studio_name}}:</p>
               <ul>
                  @foreach ($product_detail_choice as $item) 
                     <li>{{$item['name']}}</li>
                  @endforeach
               </ul>
               <p>Syarat &amp; Ketentuan:</p>
               {!! $product_description !!}
            </div>
         </div>
         <div class="flex-column flex-lg-row-auto w-100 w-xl-350px">
            <div class="mb-10 mt-0 mt-xl-4 d-flex justify-content-center" wire:ignore>
               <input class="d-none" wire:model.live="booking_date" id="booking_date" placeholder="Select a date" type="text" readonly="readonly">
            </div>
            <div class="d-flex justify-content-center">
               <div class="box-time">
                  <div class="nav nav-pills nav-pills-custom mb-3" role="tablist">
                     @foreach ($product_booking_times as $index => $item)
                        @if (!$item['booking_detail_id'])
                           <div class="card mb-2 shadow-none border-dashed-f4 rounded-3 mh-0px mx-1 bg-blocked-30" style="width: 78px;" wire:click="handleBookingTime('{{ Crypt::encrypt($index) }}')" > 
                              <label class="select-time p-2 select-booking-time-30 {{ ($item['is_checked']) ? 'times-checkbox-checked' : '' }}" data-time="19:00:00" data-key="30"> 
                                 <label class="mx-3 align-middle cursor-pointer"> 
                                    <span class="font-size-12px fw-bold cursor-pointer"></span>
                                    {{ \Carbon\Carbon::parse($item['time'])->format('H:i') }} 
                                 </label> 
                              </label> 
                           </div>
                        @else
                           {{-- Booked --}}
                           <div class="card mb-2 shadow-none border-dashed-f4 rounded-3 mh-0px mx-1 bg-blocked-0" style="background: #e3e3e3; width: 78px;" disabled="true"> <label class="blocking-time p-2 select-booking-time-0" data-time="09:00:00" data-key="0"> <label class="mx-3 align-middle cursor-default"> <span class="font-size-12px fw-bold cursor-default"></span>{{ \Carbon\Carbon::parse($item['time'])->format('H:i') }} </label> <input class="booking-times" type="checkbox" name="times[]" value="09:00:00"></label> </div>
                        @endif
                     @endforeach
                  </div>
               </div>
            </div>
            
            <div id="product-additional" class="mt-10">
               @foreach ($product_booking_details as $bookingIndex => $product_booking)
               <div id="booking-key-30" class="container mb-5 booking-key">
                  <lable>
                     <h4>Background for {{ \Carbon\Carbon::parse($product_booking['time'])->format('H:i') }} :</h4>
                  </lable>
                  <div class="box-accessories">
                     @foreach ($product_booking['product_details'] as $detailIndex => $product_detail)
                        <div wire:click="handleProductDetail('{{$bookingIndex}}', '{{$detailIndex}}')" class="card mb-2 shadow-none border rounded-3 mh-0px product-detail">
                           <label class="addon-checkbox p-2 class-key-30 {{ ($product_detail['is_checked']) ? 'addon-checkbox-checked' : ''}}" data-key="key-30" addon-id="3a6e5bbf-61ef-43b0-b389-771651e741c3" addon-value-price="0">
                           <a class="d-inline overlay" data-fslightbox="{{ rand()}}" href="{{ $product_detail['image_url'] }}" style="height: 80px !important; width: 80px !important; z-index: 99;">
                              <!--begin::Image-->
                              <img class="img-responsive img-detail rounded-3" width="80" height="80" src="{{ $product_detail['image_url'] }}">
                              <!--end::Image-->
                              <!--begin::Action-->
                              <div class="overlay-layer card-rounded bg-transparent">
                                    <i class="bi bi-eye-fill text-white fs-5 eye-button"></i>
                              </div>
                              <!--end::Action-->
                           </a>
                           <label for="addon-0-30" class="ms-3 align-middle" style="width: 180px">
                           <span class="fs-5 fw-bold">{{ $product_detail['name'] }}</span><br>
                           <small>{{ $product_detail['description'] }}</small>
                           </label>
                           </label>
                        </div>

                        @endforeach
                  </div>
               </div>
               @endforeach
            </div>
            <div class="container">
               {!! $product_note !!}
            </div>
            <div class="container mt-5">
               <button type="submit" class="btn text-white w-100" style="background-color: #5d2fc2; ">
               <span wire:loading.class="d-none" class="text-white indicator-label">Booking</span>
               <span wire:loading class="text-white indicator-progress">Please wait...
               <span wire:loading class="text-white spinner-border spinner-border-sm align-middle ms-2"></span>
               </span>
               </button>
            </div>
         </div>
      </div>

      @include('app.components.loading-indicator')
   </form>
   <!-- Popup -->
   <div id="terms-popup" style="display: none; width: 600px; max-width: 100%; max-height: 80vh; padding: 20px; box-sizing: border-box; overflow-y: auto; margin: 0 auto; background: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: left; z-index:9999;">
      <button id="scroll-up" class="btn btn-secondary btn-sm position-absolute top-0 start-0 m-2">
         Scroll Up
         <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 16 16">
            <path fill="currentColor" fill-rule="evenodd" d="M10 2a2 2 0 1 0-4 0a2 2 0 0 0 4 0m1.78 8.841a.75.75 0 0 1-1.06 0l-1.97-1.97v6.379a.75.75 0 0 1-1.5 0V8.871l-1.97 1.97a.75.75 0 1 1-1.06-1.06l3.25-3.25L8 6l.53.53l3.25 3.25a.75.75 0 0 1 0 1.061" clip-rule="evenodd" />
         </svg>
      </button>

      <button id="scroll-down" class="btn btn-secondary btn-sm position-absolute top-0 end-0 m-2">
         Scroll Down
         <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 16 16">
            <path fill="currentColor" fill-rule="evenodd" d="M10 14a2 2 0 1 1-4 0a2 2 0 0 1 4 0m1.78-8.841a.75.75 0 0 0-1.06 0l-1.97 1.97V.75a.75.75 0 0 0-1.5 0v6.379l-1.97-1.97a.75.75 0 0 0-1.06 1.06l3.25 3.25L8 10l.53-.53l3.25-3.25a.75.75 0 0 0 0-1.061" clip-rule="evenodd" />
         </svg>
      </button>
      <!-- <hr class="mt-0 mb-4"> -->
      <div style="overflow-y: auto; max-height: 60vh; padding-right: 20px;" class="text-start">
         {!! $product_description !!}
      </div>
      <br>
      <hr class="mt-0 mb-4">

      <div class="form-check form-check-custom form-check-solid form-check-sm my-3">
         <input class="form-check-input" type="checkbox" style="border: 1px solid #ccc; border-color: black;" id="terms-checkbox">
         <label class="form-check-label d-flex align-items-center text-start" for="terms-checkbox">
            Saya sudah membaca dan setuju dengan syarat dan ketentuan di atas
         </label>
      </div>

      <div class="form-check form-check-custom form-check-solid form-check-sm my-3">
         <input class="form-check-input" type="checkbox" style="border: 1px solid #ccc; border-color: black;" id="follow-checkbox">
         <label class="form-check-label d-flex align-items-center text-start" for="wajib-follow">
            Saya menyetujui untuk tag story instagram @ dan pengisian Quizioner untuk mendapatkan SOFTCOPY GRATIS
         </label>
      </div>

      <div class="form-check form-check-custom form-check-solid form-check-sm my-3">
         <input class="form-check-input" type="checkbox" style="border: 1px solid #ccc; border-color: black;" id="agreement_photo_usage_checkbox">
         <label class="form-check-label d-flex align-items-center text-start" for="agreement_photo_usage">
            Saya setuju dan secara sukarela mengizinkan jika hasil foto Saya di dapat digunakan untuk keperluan promosi dan konten di .
         </label>
      </div>
   </div>
</div>

@push('css')
    <link href="{{ asset('assets/css/custom-homepage.css') }}" rel="stylesheet" type="text/css" />
    <style>
       span.today{
          background-color: #DBDFE9;
       }
      span.flatpickr-day{
         border-radius: 0.475rem;
      }
      .overlay:hover .img-detail {
         filter: brightness(0.7);
      }

      .overlay:hover .eye-button {
         filter: none !important;
      }
      .product-detail,
      .product-detail * { 
         cursor: pointer; 
      }
      .custom-swal2-title {
         font-size: 1.5em;
         margin-top: 4px;
      }

      #swal2-html-container.custom-swal2-html-container {
         padding: 5px;
         font-size: 1.2em;
         border: 1px solid #ccc;
         border-color: #ccc;
      } 
    </style>
@endpush

@push('js')
   <script src="{{ asset('assets/plugins/custom/fslightbox-basic-3.5.1/fslightbox.js') }}"></script>
   <script>
      refreshFsLightbox();
      $(document).ready(function() {
         $("#booking_date").flatpickr({
               enableTime: false,
               dateFormat: "Y-m-d",
               minDate: "today",
               inline: true,
               defaultDate: "today",
               disable: [
                  function(date) {
                        return date.getDay() == "{{config('template.setting_holiday')}}";
                  }
               ]
         });
      });

      Livewire.on('refreshFsLightbox', (res) => {
         setTimeout(() => {
            refreshFsLightbox();
         }, 200);
      });

      // LOGIN ALERT
      Livewire.on('loginAlert', (res) => {
         Swal.fire({
               icon: 'warning',
               title: 'Peringatan',
               text: 'Anda harus Sign In terlebih dahulu untuk melanjutkan booking.',
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: 'Sign In',
               cancelButtonText: 'Tidak',
         }).then((result) => {
               if (result.isConfirmed) {
                  window.location = "{{ route('login')}}";
                  return false;
               } else {
                  return;
               }
         });
      })

      // BOOKING TERM & CONDITION POPUP
      var freeSoftFile = 0;
      var agreementPhotoUsage = 0;
      Livewire.on('booking_term', (res) => {
         Swal.fire({
            title: "Syarat & Ketentuan",
            html: document.getElementById("terms-popup").innerHTML,
            showCancelButton: true,
            confirmButtonText: "Lanjutkan",
            cancelButtonText: "Batal",
            customClass: {
               title: "custom-swal2-title",
               htmlContainer: "custom-swal2-html-container",
            },
            width: 700,
            didOpen: () => {
               // Tambahkan event listener untuk tombol scroll
               const scrollButton = Swal.getPopup().querySelector("#scroll-down");
               scrollButton.addEventListener("click", () => {
                  const termsCheckbox = Swal.getPopup().querySelector("#terms-checkbox");
                  termsCheckbox.scrollIntoView({ behavior: "smooth", block: "center" });
               });
   
               // Tombol Scroll Up
               const scrollUpButton = Swal.getPopup().querySelector("#scroll-up");
               scrollUpButton.addEventListener("click", () => {
                  const popupContent = Swal.getPopup().querySelector(
                     ".swal2-html-container"
                  );
                  popupContent.scrollTo({ top: 0, behavior: "smooth" });
               });
            },
            preConfirm: () => {
               const termsCheckbox = Swal.getPopup().querySelector("#terms-checkbox");
               const followCheckbox = Swal.getPopup().querySelector("#follow-checkbox");
               const agreementPhotoUsageCheckbox = Swal.getPopup().querySelector("#agreement_photo_usage_checkbox");
   
               if (!termsCheckbox.checked) {
                  Swal.showValidationMessage(
                     "Anda harus menyetujui syarat dan ketentuan"
                  );
               }
               freeSoftFile = followCheckbox.checked ? 1 : 0;
               agreementPhotoUsage = agreementPhotoUsageCheckbox.checked ? 1 : 0;
               return [freeSoftFile, agreementPhotoUsage];
            },
            
         }).then((result) => {
            if (result.isConfirmed) {
               var booking_date = $('[name="booking_date"]').val();
               var booking_time = $(".select-time")
                  .map(function () {
                     if ($(this).hasClass("times-checkbox-checked")) {
                        return $(this).attr("data-time");
                     }
                  })
                  .get();
               var booking_addon = $(".addon-checkbox")
                  .map(function () {
                     if ($(this).hasClass("addon-checkbox-checked")) {
                        return $(this).attr("addon-id");
                     }
                  })
                  .get();
               var booking_accessories = $(".accessories-checkbox")
                  .map(function () {
                     if ($(this).hasClass("accessories-checkbox-checked")) {
                        return $(this).attr("addon-id");
                     }
                  })
                  .get();
               if (booking_time == "") {
                  toastr.warning("Jam booking belum dipilih.", "Warning!", {
                     timeOut: 2000,
                     extendedTimeOut: 0,
                     closeButton: true,
                     closeDuration: 0,
                  });
                  $("html, body").animate(
                     { scrollTop: $(".box-time").offset().top - 100 },
                     "slow"
                  );
                  return false;
               }
               if (booking_addon.length < booking_time.length) {
                  toastr.warning("Background belum dipilih.", "Warning!", {
                     timeOut: 2000,
                     extendedTimeOut: 0,
                     closeButton: true,
                     closeDuration: 0,
                  });
                  $("html, body").animate(
                     { scrollTop: $("#product-additional").offset().top - 100 },
                     "slow"
                  );
                  $("html, body").animate(
                     { scrollTop: $("#term-confirmation").offset().top - 100 },
                     "slow"
                  );
                  return false;
               }
   
               @this.call('createOrder');
            }
         });
      })
   </script>
@endpush
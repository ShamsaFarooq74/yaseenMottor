 <footer id="footer">
     <div class="container-fluid custom-footer">
         <div class="footer-top">
             <div class="container pt-5">
                 <div class=" row d-flex justify-content-center justify-content-lg-between pt-5 px-5 pb-3">
                     <div class="col-lg-3 col-md-3 col-sm-3  footer-links d-flex justify-content-left">
                         <div>
                             <div class="mb-3"><a href="{{url('/')}}"><img
                                         src="{{ asset('assets/images/'.$setting->values) }}" /></a>
                             </div>
                             <p class="mt-2">Yaseen Motors Co., Ltd, established Japanese and Global New and Used Vehicle Exporter and Importer.
                             </p>
                             <div class="social-icons text-lg-end d-flex mt-3">
                                 <a href="#" class="me-2"><img
                                         src=" {{ asset('user_assets/img/details/social/twiter.png') }}" />
                                 </a>
                                 <a href="https://www.facebook.com/singaporeexportscars?mibextid=LQQJ4d" class="me-2"><img
                                         src="{{ asset('user_assets/img/details/social/facebook.png') }}" />
                                 </a>
                                 <a href="https://instagram.com/yaseen_motors?igshid=OGQ5ZDc2ODk2ZA==" class="me-2"><img
                                         src=" {{ asset('user_assets/img/details/social/instagram.png') }}" />
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-3  footer-links d-flex justify-content-left">
                         <div>
                             <b>COMPANY</b>
                             <ul class="mt-2">
                                 <li><i class="bx bx-chevron-right"></i> <a href="{{ route('aboutus') }}">About Us</a>
                                 </li>
                                 <li><i class="bx bx-chevron-right"></i> <a href="{{ route('user.payment') }}">Payment</a>
                                 </li>
                                 <li><i class="bx bx-chevron-right"></i> <a href="{{ route('services') }}">Services</a> </li>
                                 <li><i class="bx bx-chevron-right"></i> <a href="{{ route('stock') }}">Stock</a> </li>

                             </ul>

                         </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-3  footer-links d-flex justify-content-left">
                         <div>
                             <b>HELP</b>
                             <ul class="mt-2">
                                 <li><i class="bx bx-chevron-right"></i> <a href="{{ route('contactus') }}">Contact Us
                                     </a>
                                 </li>
                                 <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy Policy</a> </li>

                             </ul>
                         </div>
                     </div>
                     <!-- <div class="col-lg-3 col-md-3 col-sm-3  footer-links d-flex justify-content-center">
                         <div>
                             <b>RESOURCE</b>
                             <ul class="mt-2">
                                 <li><i class="bx bx-chevron-right"></i> <a href="#">Find Cars</a>
                                 </li>
                                 <li><i class="bx bx-chevron-right"></i> <a href="#">How to Blog</a>
                                 </li>
                                 <li><i class="bx bx-chevron-right"></i> <a href="#">Find Cars</a>
                                 </li>
                                 <li><i class="bx bx-chevron-right"></i> <a href="#">How to Blog</a>
                                 </li>

                             </ul>
                         </div>
                     </div> -->
                     <div class="container-fluid mt-5" id="footer-bottom">
                         <div class="container copyright pt-4">
                             © {{Date('Y')." ". env("APP_NAME")}}. All rights reserved.

                         </div>

                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- <div class="container-fluid" id="footer-bottom">
         <div class="container copyright pt-2 pb-2 ">
             <a href='index.html'>© 2023 Untitled UI. All rights reserved.</a>

         </div> -->

     </div>
 </footer>
 <script>
     $(document).ready(function () {
         $('#make_id').on('change', function () {
             var makeId = $(this).val();
             if (makeId) {
                 $.ajax({
                     type: 'POST',
                     url: '{{ route('model.by.make') }}',
                     data: {
                         _token: '{{ csrf_token() }}',
                         makeId: makeId
                     },
                     success: function (respose) {
                         console.log(respose);
                         $('#model_id').empty();
                         $('#model_id').append(
                             '<option value="" selected disabled>Select Model</option>'
                         );
                         $.each(respose, function (key, model) {
                             $('#model_id').append('<option value="' + model
                                 .id +
                                 '">' + model.model_name + '</option>');
                         });
                     },
                     error: function (xhr, status, error) {
                         console.error(xhr.responseText);
                     }
                 });
             } else {
                 $('#model_id').empty();
                 $('#model_id').prop('disabled', true);
             }
         });
     });
 </script>
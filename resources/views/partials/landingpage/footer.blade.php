<!-- ======= Footer ======= -->
<footer id="contact">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 footer-contact">
                    <a href="index.html" class="logo">
                        <img src="/assets/img/logo-primary.svg" alt="" class="img-fluid w-50 mb-4"></a>
                        @php
                            $deskripsi = $data->deskripsi ?? 'Langkah Education adalah website belajar untuk persiapan tes seleksi masuk PTN'
                        @endphp
                    <p>{{ $deskripsi }}</p>
                </div>
                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>Hubungi Kami</h4>
                    <strong><i class="fa fa-home font-weight-bold mr-2"></i></strong>  {{ $data->alamat ?? '' }}<br>
                    <strong><i class="fab fa-whatsapp font-weight-bold mr-2"></i></strong> {{ $data->noHP ?? '' }}<br>
                    <strong><i class="fa fa-envelope font-weight-bold mr-2"></i></strong> {{ $data->email ?? '' }}<br>
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>Media Sosial</h4>
                    <div class="mr-md-auto social-links text-center text-md-left pt-3 pt-md-0 mb-5">
                        <a href="{{ $data->urlIG.$data->akunIG }}" class="instagram"><i class="fab fa-instagram"></i></a>
                        <a href="{{ $data->urlTwitter.$data->akunTwitter }}" class="twitter"><i class="fab fa-twitter"></i></a>
                        <a href="{{ $data->urlFB.$data->akunFB }}" class="facebook"><i class="fab fa-facebook"></i></a>
                        <a href="{{ $data->urlYoutube.$data->akunYoutube }}" class="google-plus"><i class="fab fa-youtube"></i></a>
                        <a href="{{ $data->urlLine.$data->akunLine }}" class="linkedin"><i class="fab fa-line"></i></a>
                    </div>

                    <div class="copyright mt-5">
                        &copy; Copyright <strong><span>Langkah Education</span></strong><br>All Rights Reserved
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer><!-- End Footer -->

<a href="#header" class="back-to-top"><i class="fas fa-angle-up"></i></a>
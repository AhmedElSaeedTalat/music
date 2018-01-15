<section class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="color_white">Hi, {{ auth()->user()->name }}</h1>
            </div>
            <div class="col-12">
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" @click="active1" id="active1">Singer Bio</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" @click="active2" id="active2">Albums</a>
                  </li>
                 <li class="nav-item">
                    <a class="nav-link" @click="active3" id="active3">Upcoming Eventss</a>
                  </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="color_white">Hi, {{ auth()->user()->name }}</h1>
            </div>
            <!--
              **
               * the menu
               *
               * info needed to the admin
               * 
              **
             -->
            <div class="col-12 mt-5">
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" @click="active1" id="active1">Tip and Links</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" @click="active2" id="active2">Latest Notifications</a>
                  </li>
                 <li class="nav-item">
                    <a class="nav-link" @click="active3" id="active3">Report</a>
                  </li>
                </ul>
            </div>
          </div>
        </div>
            <section id="tips" v-show="tips">
       @include('tips')    
  </section>
</section>
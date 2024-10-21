@include('admin.layouts.header')

@include('admin.layouts.navbar')

<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        @include('admin.layouts.sidebar')

        <!-- Main content -->
        <div class="content-wrapper">
            
            <!-- Page header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4><i class="icon-arrow-right6 position-left"></i>سامانه مدیریت وظایف</h4>
                    </div>

                </div>
            </div>
            <!-- /page header -->

            {{$slot}}

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

@include('admin.layouts.footer')
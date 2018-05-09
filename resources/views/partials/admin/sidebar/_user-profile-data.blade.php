<div class="profile clearfix">
    <div class="profile_pic">
        <img src="{{ asset('images/admin/img.jpg') }}" alt="{{ auth()->user()->name }}" class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>Welcome,</span>
        <h2>{{ auth()->user()->name }}</h2>
    </div>
    <div class="clearfix"></div>
</div>

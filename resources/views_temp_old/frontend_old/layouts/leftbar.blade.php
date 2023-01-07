<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 left-bar">
    <div class="logo col-xs-4 col-sm-12"><a href="{{ asset('/') }}"><img src="{{ asset('images/logo.png') }}" alt="GoduTV"></a></div>
    <div class="menu col-xs-8 col-sm-12">
        <div class="menu-icon hide" onclick="menu();"><i class="glyphicon glyphicon-menu-hamburger"></i></div>
        <ul class="no-padding">
         @foreach ($category as $cat)
            @if($category_id_parent == $cat->category_id )     
                <li class="menu-item active">
                    <div class="logo-item">
                        <a href="{{ asset('category/'.$cat->category_alias.'/'.$cat->category_id) }}">
                        @if(!empty($cat->category_image_hover))
                            <img src="{!! asset('uploads/category/'.$cat->category_image_hover) !!}" alt="{{ $cat->category_name }}" style="width:100px;height:100px;"> 
                        @endif
                    </div>
                    <div class="name-item"><a href="{{ asset('category/'.$cat->category_alias.'/'.$cat->category_id) }}">{{ $cat->category_name }}</a></div>
                </li>
            @else
                <li class="menu-item">
                    <div class="logo-item">
                        <a href="{{ asset('category/'.$cat->category_alias.'/'.$cat->category_id) }}">
                        @if(!empty($cat->category_image))
                            <img src="{!! asset('uploads/category/'.$cat->category_image) !!}" alt="{{ $cat->category_name }}" style="width:100px;height:100px;">
                        @endif
                    </div>
                    <div class="name-item"><a href="{{ asset('category/'.$cat->category_alias.'/'.$cat->category_id) }}">{{ $cat->category_name }}</a></div>
                </li>
            @endif
        @endforeach
        </ul>
    </div>
</div> <!-- end .left-bar -->
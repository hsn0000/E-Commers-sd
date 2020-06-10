<?php
use App\Product; 
use App\ProductsAttribute; 
use App\Category;
    $url = "t-shirts";
    $currentUrl = url()->current();
    if(!isset($sizeArray))  { 
        $sizeArray = ProductsAttribute::select('size')->where('size', '!=', '')->where('size', '!=', 'tes')->groupBy('size')->get(); 
        $sizeArray = array_flatten(json_decode(json_encode($sizeArray),true)); 
    }
    if(!isset($categories)) {
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
    }
    $urlPreg =  preg_match("/product/i",$currentUrl)
?>

<form action="{{url('products/filter')}}" method="post" > {{ csrf_field() }}
 <input type="hidden" value="{{$url}}" name="url">
    <div class="left-sidebar">
        <h2>{{__('frontend.category')}}</h2>
        <div class="panel-group category-products" id="accordian">
                <!--category-productsr-->
            <div class="panel panel-default">
                <!-- <-?php echo $categories_menu -->
                @foreach($categories as $cat)
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#{{$cat->id}}">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            {{$cat->name}}
                        </a>
                    </h4>
                </div>

                <div id="{{$cat->id}}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            @foreach($cat->categories as $subcat)
                            @php $productCount = Product::productCount($subcat->id) @endphp
                            @if($subcat->status == "1")
                            <li><a href="{{'/products/'.$subcat->url}}">{{$subcat->name}}</a> ({{$productCount}}) </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!--/category-products-->
    @if(empty($lie))
        <!-- filter -->
        <h2>Filters</h2>
        <div class="panel-group category-products" id="filter">
            <div class="panel panel-default">
 
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#filter" href="#size">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            Size
                        </a>
                    </h4>
                </div>
                <!-- **** -->
                <div id="size" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            @foreach($sizeArray as $sizes) @if(!empty($_GET['size'])) @php $sizeArr = explode( '-', $_GET['size']); @endphp @if( in_array($sizes,$sizeArr)) @php $sizeCheck = "checked"; @endphp @else @php $sizeCheck = ""; @endphp @endif @else  @php $sizeCheck = ""; @endphp @endif 
                              <li>  <input type="checkbox" name="sizeFilter[]" id="{{ $sizes }} " value="{{ $sizes }} " onchange="javascript:this.form.submit();" {{ $sizeCheck }} > &nbsp; <span class="products-colors"> {{ $sizes }} </span></input> </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
           
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#filter" href="#colorss">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            Color
                        </a>
                    </h4>
                </div> 
                @if(!empty($_GET['color']))
                  @php $colorArray = explode( '-', $_GET['color']);  @endphp
                @endif 
                <div id="colorss" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            @foreach(config('customeArr.color') as $col)
                             <li> <input type="checkbox" name="colorFilter[]" id="{{$col}}" value="{{$col}}" onchange="javascript:this.form.submit();" @if(!empty($colorArray)) @foreach($colorArray as $colArr) @if($col ==  $colArr ) checked @endif  @endforeach @endif> &nbsp; <span class="products-colors">{{$col}}</span></<input> </li>
                            @endforeach
                        </ul>
                       </div>
                 </div>

                 <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#filter" href="#sleeves">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            Sleeves
                        </a>
                    </h4>
                </div>
                 @if(!empty($_GET['sleeve']))
                 @php $slvArray = explode( '-', $_GET['sleeve']);  @endphp
                 @endif 
                <div id="sleeves" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            @foreach(config('customeArr.sleeveArray') as $sleev)
                             <li>  <input type="checkbox" name="sleeveFilter[]" id="{{$sleev}}" value="{{$sleev}}" onchange="javascript:this.form.submit();" @if(!empty($slvArray)) @foreach($slvArray as $slv) @if($sleev ==  $slv ) checked @endif  @endforeach @endif> &nbsp; <span class="products-colors">{{$sleev}}</span></<input> </li>
                            @endforeach
                        </ul>
                       </div>
                 </div>

                 <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#filter" href="#patterns">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            Pattern
                        </a>
                    </h4>
                </div>
                @if(!empty($_GET['pattern']))
                 @php $ptrArray = explode( '-', $_GET['pattern']);  @endphp
                @endif 
                <div id="patterns" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            @foreach(config('customeArr.patternArray') as $pttr)
                             <li>  <input type="checkbox" name="patternFilter[]" id="{{$pttr}}" value="{{$pttr}}" onchange="javascript:this.form.submit();" @if(!empty($ptrArray)) @foreach($ptrArray as $ptrAr) @if($pttr ==  $ptrAr ) checked @endif  @endforeach @endif> &nbsp; <span class="products-colors">{{$pttr}}</span></<input> </li>
                            @endforeach
                        </ul>
                       </div>
                 </div>

            </div>
        </div>
    @endif

        <div class="price-range">
            <!--price-range-->
            <h2>{{__('frontend.price_range')}}</h2>
            <div class="well text-center">
                <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="500000" data-slider-step="5"
                    data-slider-value="[250,450]" id="sl2"><br />
                <b class="pull-left">Rp 0</b> <b class="pull-right">Rp 5,000,000</b>
            </div>
        </div>
        <!--/price-range-->
        @if(!empty($billboard))
        @foreach($billboard as $bill)
        <div class="shipping text-center" style="padding-top: unset;">
            <!--shipping-->
            <img src="{{ asset('images/backend_images/banners/'.$bill->image) }}" alt="" />
        </div>
        @endforeach
        @endif
        <!--/shipping-->

    </div>
</form>
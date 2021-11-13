@extends('layouts.app')
@section('title', 'Search Cloud | 123Torrents - Torrent Search Engine')
@section('description', 'Verified Torrents Download like Movies, Games, Music, Anime, TV Shows and Software, Bittorrent Downloading Absolutely for free at 123Torrents')

@section('content')
<style>
#breadcrumb_stats li {
    list-style-type: none;
    display: inline;
    margin-right: 70px;
}
.torrents_table td { font-size: 14px; }
</style>
<div style="height: 30px; background-color: #fcfcfc; border-bottom: 1px solid #d1cfc5;  border-top: 1px solid #f0f0f5;  box-shadow: 0 1px 3px rgba(0,0,0,0.10), 0 1px 2px rgba(0,0,0,0.12);">
    <div class="container" style="text-align: left; border: 1px solid #fcfcfc;">
        <span><small style="font-size: 73%;">
            <i class="fa fa-home"></i>  <a href="/" style="color: #777;">Home</a>
        </small></span>
    </div>
</div>


<style>
#hm-search .form-control {
    height: 56px;
    background: #fff;
    font-size: 20px;
    padding-left: 20px;
    padding-right: 90px;
    box-shadow: none;
    color: #111;
    border: 1px solid rgba(0,0,0,0.2);
    border-radius: 5px;
    display: inline;
    width: 92.3%;
    padding-right: 0px;
    border-right: 0px;
}

</style>

<script type="text/javascript">
$(document).ready(function() {
    $(".searh_cloud_query").click(function() {
        $("#search_header_txt").val($(this).html());
        $("#search_header_submit").click();
        return false;
    })
});
</script>

<!--tab start-->
<div class="container blank">
    <div class="no-table-blank-state row" style="margin-top: 15px;">


                <div class="row">
                    <section class="row component-section" style="margin-top: 0px;">
                        <div class="col-md-12">
                            <div class="card-content-area">
                                <div class="content-area-header">
                                    <a href="#">Search Cloud</a>
                                </div>
                                @php $i = 0; @endphp
                                <div class="content-area-body">
                                    @foreach($terms as $term) 
                                        @php $i++; @endphp
                                        <a href="/torrents?keyword={{$term->query}}" class="searh_cloud_query">{{$term->query}}</a> 

                                        @if($i != count($terms)) &middot; @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
    </div>
</div>



@endsection

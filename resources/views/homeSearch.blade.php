@extends('layouts.app')
@section('title', '123Torrents - Torrent Search Engine')
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

	    	<span><small  class="text-muted" style="font-size: 73%;">
	        	<i class="fa fa-angle-right"></i> Recent Torrents
	    	</small></span>
    </div>
</div>


<!--tab start-->
<div class="container blank">
    <div class="no-table-blank-state row" style="margin-top: 15px;">
        @if(Auth::User()) 
            Welcome back, {{Auth::User()->name}}!
        @endif
        <div class="row">
            <div class="col-md-12">


 @foreach($categories as $category) 
                <div class="row">
                    <section class="row component-section">
                   
                        <!-- hoverable rows table title and description  -->
                        <div class="col-md-12">

                            <div class="pull-left">
                                <div id="hoverable-row-table">
                                    <h2>@php echo $category->Icon() @endphp Popular {{$category->title}} Torrents <small>(last 7 days)</small></h2>
                                </div>
                            </div>

                            <div class="pull-right">
                                <a href="/top/{{strtolower(explode(" ", $category->title)[0])}}" class="btn btn-default">View All</a>
                            </div>

                        </div> <!-- hoverable rows table title and description end -->
                        
                        <div class="col-md-12">
                            <div class="component-box">
                            
                                <!-- hoverable rows table example -->
                                <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                                    <div class="table-responsive">
                                        <table class="table pmd-table table-hover table-striped torrents_table">
                                            <thead>
                                                <tr>
                                                    <th class="">Title</th>
                                                    <th>&nbsp;</th>
													<th class="">Added</th>
                                                    <th class="">Size</th>
                                                    <th class="">Seeders</th>
                                                    <th class="">Leechers</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            	@php 
                                            		$date = new Carbon\Carbon;
													$date->subWeek();

                                            		$movies = App\Torrent::remember(3600)->select ('id', 'title', 'torrent_url', 'size', 'file_count', 'seeders', 'leechers', 'created_at', 'info_hash', 'category_id')->where("category_id", "=", $category->id)->where("created_at", ">", $date->format('Y-m-d'))->orderByRaw("leechers DESC")->orderBy("id", "DESC")->simplePaginate (10);

                                            	@endphp
                                                @foreach($movies as $torrent)
                                                    <tr>
                                                        <td class=""><a href="/torrent/{{$torrent->id}}/{{$torrent->slug()}}" style="font-size: 14px;">{{$torrent->title}}</a></td>
                                                        <td>
                                                            <a href="http://itorrents.org/torrent/{{$torrent->info_hash}}.torrent" target="_blank" data-toggle="tooltip" title="Download Torrent">
                                                                <i class="fa fa-floppy-o"></i>
                                                            </a> &middot;
                                                            <a href="{{$torrent->MagnetURI()}}" data-toggle="tooltip" title="Magnet URI">
                                                                <i class="fa fa-magnet fa-rotate-180"></i>
                                                            </a>
                                                        </td>
					 									<td class="">{{\Carbon\Carbon::parse($torrent->created_at)->format('M jS, Y')}} 
					 								<small>({{\Carbon\Carbon::createFromTimeStamp(strtotime($torrent->created_at))->diffForHumans()}})</small></td>

                                                        <td class="">{{formatSizeUnits($torrent->size)}}</td>
                                                        <td class="text-center" style="color: green;"><i class="fa fa-arrow-up"></i> {{$torrent->seeders}}</td>
                                                        <td class="text-center" style="color: red;"><i class="fa fa-arrow-down"></i> {{$torrent->leechers}}</td>                                
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- hoverable rows table example end -->
                            
                            </div>
                        </div>
                    </section>
                </div>

                @endforeach


            </div>


        </div>
    </div>
</div>
@endsection

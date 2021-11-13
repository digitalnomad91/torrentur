@extends('layouts.app')

@section('title', 'Browse Torrents | 123Torrents - Torrent Search Engine')
@section('description', 'Verified Torrents Download like Movies, Games, Music, Anime, TV Shows and Software, Bittorrent Downloading Absolutely for free at 123Torrents')



@section("content")		

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

		@if(!$category)
	    	<span><small  class="text-muted" style="font-size: 73%;">
	        	<i class="fa fa-angle-right"></i> Torrents
	    	</small></span>
		 @else
    	<span><small style="font-size: 73%;">
        	<i class="fa fa-angle-right"></i>  <a href="/torrents" style="color: #777;">Torrents</a>
    	</small></span>
	    	<span><small  class="text-muted" style="font-size: 73%;">
	        	<i class="fa fa-angle-right"></i> {{$category->title}}
	    	</small></span>

		 @endif
    </div>
</div>

	<!-- main-container start -->
	<!-- ================ -->
	<section class="main-container" style="padding-top: 15px;">

		<div class="container">
			<div class="row">
				<!-- main start -->
				<!-- ================ -->
				<div class="main col-md-12">

					<div class="row">
						@include("torrents.filters")
					</div>

					@php
						$queryString = http_build_query($request->query());
					@endphp

					<section class="row component-section">
						<div class="col-md-12"> 
							<div class="pmd-card pmd-z-depth pmd-card-custom-view">
								<div class="pmd-card-body">
									<div class="row" id="nav_links"> 
										<div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
											<a href="/browse/movies@php if($queryString) echo "?$queryString" @endphp"><i class='fa fa-film' style="font-size: 28px;"></i><br>
											<small class="text-muted">Movies</small></a>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
											<a href="/browse/tv@php if($queryString) echo "?$queryString" @endphp"><i class='fa fa-tv' style="font-size: 28px;"></i><br>
											<small class="text-muted">TV Shows</small></a>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
											<a href="/browse/games@php if($queryString) echo "?$queryString" @endphp"><i class='fa fa-gamepad' style="font-size: 28px;"></i><br>
											<small class="text-muted">Games</small></a>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
											<a href="/browse/music@php if($queryString) echo "?$queryString" @endphp"><i class='fa fa-music' style="font-size: 28px;"></i><br>
											<small class="text-muted">Music</small></a>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
											<a href="/browse/software@php if($queryString) echo "?$queryString" @endphp"><i class='fa fa-cogs' style="font-size: 28px;"></i><br>
											<small class="text-muted">Software</small></a>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
											<a href="/browse/xxx@php if($queryString) echo "?$queryString" @endphp"><i class='fa fa-venus-mars' style="font-size: 28px;"></i><br>
											<small class="text-muted">XXX</small></a>
										</div>																														

									</div>
								</div>
							</div>
						</div>
					</section>


					<style>
						nav_links{ 
							a { color: black !important; }
						}
					</style>

			<section class="row component-section">
			
				<!-- hoverable rows table title and description  -->
				<div class="col-md-12">

					<div class="pull-left">
						<div id="hoverable-row-table">

							@if(!$request->input("keyword"))
								<h2><i class="fa fa-database"></i> Browse @if($category) {{$category->title}} @endif Torrents</h2>
							@else
								<h2><i class="fa fa-search"></i> Search Results for {{$request->input("keyword")}}</h2>
							@endif
						</div>
						<small class="text-muted"><p>Displaying results for your search query from our database of over <code>16 million</code> torrents and counting.</p></small>
					</div>

					<div class="pull-right">
						<button type="button" class="btn pmd-btn-raised pmd-ripple-effect btn-default" id="filters_btn">
							<i class="fa fa-sort mr5"></i> Filter
						</button>
					</div>

					<script type="text/javascript">
						$(document).ready(function() {
							$("#torrents_search").hide();
						});

						$("#filters_btn").click(function() {
							$("#torrents_search").slideDown("fast", function() {
						        <!-- Simple Selectbox -->
						        $(".select-simple").select2({
						            theme: "bootstrap",
						            minimumResultsForSearch: Infinity,
						        });
						        <!-- Selectbox with search -->
						        $(".select-with-search").select2({
						            theme: "bootstrap"
						        });
						        <!-- Select Multiple Tags -->
						        $(".select-tags").select2({
						            tags: false,
						            theme: "bootstrap",
						        });
						        <!-- Select & Add Multiple Tags -->
						        $(".select-add-tags").select2({
						            tags: true,
						            theme: "bootstrap",
						        });

							});
						});
					</script>
					

				</div> <!-- hoverable rows table title and description end -->
				
				<div class="col-md-12">
					<div class="component-box">
										@php
											$queryString = http_build_query($request->query());
											$queryString = querystring_remove_var($queryString, "sort");
											$queryString = querystring_remove_var($queryString, "sortby");

											if($request->input("sort") == "desc") $queryString = $queryString."&sort=asc";
												else $queryString = $queryString."&sort=desc";
										@endphp
						<!-- hoverable rows table example -->
						<div class="pmd-card pmd-z-depth pmd-card-custom-view">
							<div class="table-responsive">
								<table class="table pmd-table table-hover table-striped torrents_table">
									<thead>
										<tr>
											<th class=""></th>
											<th class="">Title</th>
											<th>&nbsp;</th>
											<th class="">
												<a href="?{{$queryString}}&sortby=created_at">
													<i class="fa {{ ($request->input("sortby") != "created_at") ? "fa-sort" : (($request->input("sort") == "desc") ? "fa-caret-up" : "fa-caret-down") }}"></i> Added
												</a>
											</th>
											<th class="">
												<a href="?{{$queryString}}&sortby=size">
													<i class="fa {{ ($request->input("sortby") != "size") ? "fa-sort" : (($request->input("sort") == "desc") ? "fa-caret-up" : "fa-caret-down") }}"></i> Size
												</a>
											</th>
											<th class="">File Count</th>
											<th class="">
												<a href="?{{$queryString}}&sortby=seeders">
													<i class="fa {{ ($request->input("sortby") != "seeders") ? "fa-sort" : (($request->input("sort") == "desc") ? "fa-caret-up" : "fa-caret-down") }}"></i> Seeders
												</a>
											</th>
											<th class="">
												<a href="?{{$queryString}}&sortby=leechers">
												 <i class="fa {{ ($request->input("sortby") != "leechers") ? "fa-sort" : (($request->input("sort") == "desc") ? "fa-caret-up" : "fa-caret-down") }}"></i> Leechers
												</a>
											</th>
										</tr>
									</thead>
									<tbody>
					 					@foreach($torrents as $torrent)
					 						<tr>
					 							<td class="text-right" style="text-align: right !important;">
					 								<a href="#" title="{{isset($torrent->Category->title) ? $torrent->Category->title : ""}}" style="font-size: 30px;" data-toggle="tooltip">
					 									@php echo isset($torrent->Category) ? $torrent->Category->Icon() : "" @endphp
					 								</a>
					 							</td>
					 							<td class=""><a href="/torrent/{{$torrent->id}}/{{$torrent->slug()}}">{{$torrent->title}}</a></td>
					 							<td>
					 								<a href="http://itorrents.org/torrent/{{$torrent->info_hash}}.torrent" target="_blank" data-toggle="tooltip" title="Download Torrent">
					 									<i class="fa fa-floppy-o"></i>
					 								</a> &middot;
					 								<a href="{{$torrent->MagnetURI()}}" data-toggle="tooltip" title="Magnet URI">
					 									<i class="fa fa-magnet fa-rotate-180"></i>
					 								</a>
					 							</td>
					 							<td class="">{{\Carbon\Carbon::parse($torrent->created_at)->format('M jS, Y')}} <br>
					 								<small>({{\Carbon\Carbon::createFromTimeStamp(strtotime($torrent->created_at))->diffForHumans()}})</small></td>
					 							<td class="">{{formatSizeUnits($torrent->size)}}</td>
					 							<td class=""><i class="fa fa-file-o"></i> {{$torrent->file_count}} files</td>
					 							<td class="text-center" style="color: green;">
					 								<i class="fa fa-arrow-up"></i> {{$torrent->seeders}}
					 							</td>
					 							<td class="text-center" style="color: red;">
					 								<i class="fa fa-arrow-down"></i> {{$torrent->leechers}}
					 							</td>	 							
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div> <!-- hoverable rows table example end -->
					
					</div>
				</div>
			</section>

			<style>
				.torrents_table tr td {
					padding: 8px !important;
				}
			</style>

					<div class="col-sm-offset-1 col-sm-12">
						{{ $torrents->appends($_GET)->links() }}
					</div>
				</div>
				<!-- main end -->

			</div>
		</div>
	</section>
	<!-- main-container end -->

@endsection



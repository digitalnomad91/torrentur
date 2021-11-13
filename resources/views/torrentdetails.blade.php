@extends('layouts.app')
@section('title', $torrent->title.' Download - 123Torrents')
@section('description', ' Download '.$torrent->title.' for free on 123Torrents')


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
      <span><small>
          <i class="fa fa-home"></i> <a href="/">Home</a>
      </small></span>
      
      <span><small>
          <i class="fa fa-angle-right"></i> <a href="/">Torrents</a>
      </small></span>
      
      <span><small>
          <i class="fa fa-angle-right"></i> <a href="/">{{isset($torrent->Category->title) ? $torrent->Category->title : ""}}</a>
      </small></span>
     


      <span><small>
          <i class="fa fa-angle-right"></i> {{$torrent->title}}
      </small></span>
    </div>
</div>

<style>
.torrent_stats td { font-size: 14px; }
</style>



<!--tab start-->
<div class="container blank">
    <div class="no-table-blank-state row" style="margin-top: 15px;">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-content-area">
                                <div class="content-area-header">
                                    <h3>
                                      <a href="#" title="{{isset($torrent->Category->title) ? $torrent->Category->title : ""}}" data-toggle="tooltip">
                                        @php echo isset($torrent->Category) ? $torrent->Category->Icon() : "" @endphp
                                      </a> {{$torrent->title}}
                                   </h3>
                                </div>
                                <div class="content-area-body">

                                  <div class="table-responsive">
                                      <table class="table pmd-table table-inverse torrent_stats">
                                        <tbody>
                                          <tr>
                                            <td style="text-align: right; padding-right: 15px; font-size: 15px; max-width: 275px;">Info Hash</td>
                                            <td data-title="Info Hash">{{$torrent->info_hash}}</td>
                                          </tr>
                                          <tr>
                                            <td style="text-align: right; padding-right: 15px; font-size: 15px; max-width: 275px;">Added</td>
                                            <td data-title="ADdded">{{\Carbon\Carbon::parse($torrent->created_at)->format('M jS, Y')}} 
                                              <small>({{\Carbon\Carbon::createFromTimeStamp(strtotime($torrent->created_at))->diffForHumans()}})</small></td>
                                          </tr>
                                          <tr>
                                            <td style="text-align: right; padding-right: 15px; font-size: 15px; max-width: 275px;">Category</td>
                                            <td data-title="Category">{{isset($category->title) ? $category->title : ""}}</td>
                                          </tr>
                                          <tr>
                                            <td style="text-align: right; padding-right: 15px; font-size: 15px;">Size</td>
                                            <td data-title="Size" style="width: 80%;">{{formatSizeUnits($torrent->size)}}</td>
                                          </tr>     
                                          <tr>
                                            <td style="text-align: right; padding-right: 15px; font-size: 15px;">File Count</td>
                                            <td data-title="File Count">{{$torrent->file_count}} files</td>
                                          </tr>   
                                          <tr>
                                            <td style="text-align: right; padding-right: 15px; font-size: 15px;">Seeders</td>
                                            <td data-title="Seeders"><span style="color: green;"><i class="fa fa-arrow-up"></i> <span class="seeders">{{$torrent->seeders}}</span></span></td>
                                          </tr>
                                          <tr>
                                            <td style="text-align: right; padding-right: 15px; font-size: 15px;">Leechers</td>
                                            <td data-title="Leechers"><span style="color: red;"><i class="fa fa-arrow-down"></i> <span class="leechers">{{$torrent->leechers}}</span></span></td>
                                          </tr>
                                          <tr>
                                            <td style="text-align: right; padding-right: 15px; font-size: 15px;">Snatched</td>
                                            <td data-title="Leechers"><span class="snatched">{{$torrent->snatched}}</span> completed
                                              <span style="font-size: 12px; color: grey;">
                                                (Last Checked: <span class="last_checked">{{\Carbon\Carbon::createFromTimeStamp(strtotime($torrent->last_scraped))->diffForHumans()}}</span> <a href="javascript: void(0);" style="font-size: 12px; color: grey;" id="re-scrape"><i class="fa fa-refresh"></i></a>)
                                              </span>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" component-box" style="margin-top: 15px;"> 
                <!--without background tab example -->
                <div class="pmd-card pmd-z-depth"> 
                  <div class="pmd-tabs">
                    <div class="pmd-tab-active-bar" style="width: 104px; left: 0px;"></div>
                    <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#descr" aria-controls="descr" role="tab" data-toggle="tab">Description</a></li>
                      <li role="presentation"><a href="#files" aria-controls="files" role="tab" data-toggle="tab">Files</a></li>
                      <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
                      <li role="presentation"><a href="#trackers" aria-controls="trackers" role="tab" data-toggle="tab">Trackers</a></li>
                    </ul>
                  </div>
                  <div class="pmd-card-body">
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="descr">
                        <div style="white-space: pre-wrap; ">{{$torrent->description}}</div>
                      </div>
                      <div role="tabpanel" class="tab-pane" id="files">
                          <table>
                            <tr>
                              <th class="col-sm-offset-1 col-sm-10">Name</th>
                              <th class="col-sm-offset-1 col-sm-2">Size</th>
                            </tr>
                            @foreach($files as $file)
                              <tr>
                                <td class="col-sm-offset-1 col-sm-10">{{$file->name}}</th>
                                <td class="col-sm-offset-1 col-sm-2">{{formatSizeUnits($file->size)}}</th>
                              </tr>
                            @endforeach
                          </table>
                      </div>

                      <div role="tabpanel" class="tab-pane" id="comments">
                        <div id="disqus_thread"></div>
                      </div>


                      <div role="tabpanel" class="tab-pane" id="trackers">
                        
                          <table>
                            <tr>
                              <th class="col-sm-offset-1 col-sm-6">URL</th>
                            </tr>
                            @foreach($trackers as $tracker)
                              <tr>
                                <td class="col-sm-offset-1 col-sm-6">{{$tracker->url}}</th>
                              </tr>
                            @endforeach
                          </table>

                      </div>



                    </div>
                  </div>
                </div> <!--without background tab example end -->
                    </div>


                </div>

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-content-area" style="border-top: 4px solid #FFB851 !important">
                                <div class="content-area-header">
                                    <a href="#"><i class="fa fa-table"></i> Overview</a>
                                </div>
                                <div class="content-area-body">
                                  <a href="{{$torrent->MagnetURI()}}" data-toggle="tooltip" title="Magnet URI" class="btn btn-info btn-lg" style="min-width: 0px;">
                                    <i class="fa fa-magnet fa-rotate-180"></i>
                                  </a>
                                  <a href="http://itorrents.org/torrent/{{$torrent->info_hash}}.torrent" data-toggle="tooltip" title=".torrent File" class="btn btn-success btn-lg">
                                    <i class="fa fa-floppy-o"></i> Download Torrent 
                                  </a>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div><!-- tab end -->


<script type="text/javascript">
$("#re-scrape").click(function() {
    $(this).html('<i class="fa fa-refresh fa-spin"></i>');
    var that = this;

    $.ajax({
      url: '/api/torrents/scrape/{{$torrent->info_hash}}',
      success: function(data) {
        $(that).html('<i class="fa fa-refresh"></i>');
        $(".seeders").html(data.seeders);
        $(".leechers").html(data.leechers);
        $(".snatched").html(data.snatched);
        $(".last_checked").html("A few moments ago");
        

      }
    })

})
</script>


<script>
    /**
     *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT 
     *  THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR 
     *  PLATFORM OR CMS.
     *  
     *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: 
     *  https://disqus.com/admin/universalcode/#configuration-variables
     */
    /**/
    var disqus_config = function () {
        // Replace PAGE_URL with your page's canonical URL variable
        this.page.url = PAGE_URL;  
        
        // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        this.page.identifier = "torrent-{{$torrent->id}}"; 
    };
    
    
    (function() {  // REQUIRED CONFIGURATION VARIABLE: EDIT THE SHORTNAME BELOW
        var d = document, s = d.createElement('script');
        
        // IMPORTANT: Replace EXAMPLE with your forum shortname!
        s.src = 'https://123torrents.disqus.com/embed.js';
        
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>
    Please enable JavaScript to view the 
    <a href="https://disqus.com/?ref_noscript" rel="nofollow">
        comments powered by Disqus.
    </a>
</noscript>
@endsection

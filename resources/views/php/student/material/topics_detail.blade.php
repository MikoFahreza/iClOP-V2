<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <title>iCLOP</title>
    <link rel="icon" href="./images/logo.png" type="image/png">
    <style>
        .text {
            font-family: 'Poppins', sans-serif;
            color: #3F3F46;
            text-decoration: none
        }

        .text-list {
            font-family: 'Poppins', sans-serif;
            color: #3F3F46;
        }

        .footer {
            background-color: #EAEAEA;
            color: #636363;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* CSS untuk mengatur sidebar */
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            height: 100%;
            position: fixed;
            top: 0;
            right: 0;
            overflow-x: hidden;
            padding-top: 20px;
        }

        /* Gaya dropdown */
        .dropdown {
            padding: 6px 8px;
            display: inline-block;
            cursor: pointer;
        }

        /* Gaya dropdown content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .list-item {
            display: flex;
            align-items: center;
            /* justify-content: space-between; */
            padding: 10px;
            border: 1px solid #E4E4E7;
            cursor: pointer;
            margin-bottom: 10px;
            border: none;
        }

        .list-item:hover {
            background-color: #F5F5F8;
        }

        .list-item-title {
            font-size: 18px;
            margin-left: 10px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            color: #3F3F46;
        }

        .list-item-icon {
            font-size: 20px;
        }

        .expandable-content {
            margin-top: 0px;
            display: none;
            padding: 10px;
            border-top: 1px solid #E4E4E7;
            border: none;
            margin-left: 32px;
        }

        .radio-label {
            font-weight: bold;
            color: #333;
            font-size: 18px;
        }

        .progress-container {
            width: 100%;
            background-color: #f1f1f1;
        }

        .progress-bar {
            width: 40;
            height: 30px;
            background-color: #4caf50;
            text-align: center;
            line-height: 30px;
            color: white;
        }

        .progress-text {
            margin-top: 10px;
            font-size: 18px;
            text-align: center;
        }
        .text:hover {
        color: black; /* Change text color to blue on hover */
        text-decoration: underline; /* Add underline on hover */
    }
    </style>
    
    <style>
        @media only screen and (max-width: 600px) {
            #sidebar {
                display: none; /* Hide sidebar on small screens */
            }

            div[style*="max-width: 800px"] {
                max-width: 90%; /* Adjust max-width of container */
            }
        }
    </style>
    <style>
        #progressbar {
            width: @php 
                    $width = session('params');
                    echo $width."%"; 
                   @endphp;
            height: 20px;
            background-color: #4caf50;
            border-radius: 10px;
        }

        
    </style>
</head>
<!-- This is body test -->

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light" style="padding: 15px 20px; border-bottom: 1px solid #E4E4E7; font-family: 'Poppins', sans-serif;">
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <img src="{{ asset('images/left-arrow.png') }}" style="height: 24px; margin-right: 10px;">
            {{ $row->title; }}
        </a>
    </nav>

     <!-- Sidebar -->
   
    

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar" style="border-left: 1px solid #E4E4E7; padding: 20px; width: 100%; max-width: 400px;">
        <p class="text-list" style="font-size: 18px; font-weight: 600; font-size: 20px"><img src="{{ asset('images/right.png') }}" style="height: 24px; margin-right: 10px; border:1px solid; border-radius:50%"> Task List</p>
        <div class="progress-container">
            <div id="progressbar"></div>
            
        </div>
        <div id="progress">0%</div>
        <ul class="list">
            @foreach($topics as $topic)
            @php
                /*$results = DB::select("select * from php_topics where id = ?", [$topic->id]);
                if (!empty($results)) {
                    $result = $results[0]; 
                    $result->id; 
                } else {
                    echo "No results found.";
                }*/
                if($topic->id == $_GET['phpid'] ){
                    $display = "display:block !important";
                    $transform = "transform: rotate(180deg); !important";
                }else{
                    $display = "";
                    $transform = "";
                }
            @endphp
            <li class="list-item" onclick="toggleItem(this)">
                <img class="list-item-icon" src="{{ asset('images/down-arrow.png') }}" style="height: 24px; @php echo $transform; @endphp">
                <span class="list-item-title">{{ $topic->title }}   </span>
            </li>
            
            <div class="expandable-content" style="@php echo $display; @endphp">
            
                <div style="display: flex; flex-direction: column; align-items: left;">
                    @php
                
                        
                        $row = DB::table('php_topics')
                        ->leftJoin('php_topics_detail', 'php_topics.id', '=', 'php_topics_detail.id_topics')
                        ->select('*')
                        ->where('php_topics_detail.id_topics', '=',   $topic->id ) 
                        ->get();
                        $no = 1;
                    @endphp
                    @foreach($row as $r)
                    @php
                    $no++;
                    $count_ = ($no/$detailCount)*10;
                        $phpdid = isset($_GET['start']) ? $_GET['start'] : '';
                        if($r->id == $phpdid and $r->id_topics == $_GET['phpid']){
                            $active = 'color:#000; font-weight:bold; text-decoration: underline;';

                        }else{
                            $active = '';
                        }
                    @endphp 
                    <div class="row">
                        <div class="col-sm-1">
                            <label class="radio-label">
                                <svg width="16" height="16" class="" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9993 2.6665C8.63555 2.6665 2.66602 8.63604 2.66602 15.9998C2.66602 23.3636 8.63555 29.3332 15.9993 29.3332C23.3631 29.3332 29.3327 23.3636 29.3327 15.9998C29.3327 8.63604 23.3631 2.6665 15.9993 2.6665ZM5.33268 15.9998C5.33268 10.1088 10.1083 5.33317 15.9993 5.33317C21.8904 5.33317 26.666 10.1088 26.666 15.9998C26.666 21.8909 21.8904 26.6665 15.9993 26.6665C10.1083 26.6665 5.33268 21.8909 5.33268 15.9998Z" fill="#71717A"></path>
                                </svg>
                            </label>
                        </div>
                        <div class="col" style="padding-bottom: 1rem;">
                            <a class="text" style="{{ $active }};" href="{{ route('php_material_detail') }}?phpid={{$topic->id}}&start={{$r->id}}" id="requirement" onclick="updateProgress(@php echo $count_ @endphp)">{{ $r->title }} </a> 
                        </div>
                    </div>
                    @endforeach
                    @php
                    $top = $topic->id;
                    $task = DB::table('php_task')->where('id_topics', $top)->first(); // Menggunakan first() untuk mengambil satu baris pertama
                    
                
                    @endphp
                    
                    @if($task)
                    @php
                    $tsk = $task->id;
                    $task_get = isset($_GET['task']) ? $_GET['task'] : '';
                    if($tsk == $task_get){
                        $active_task = 'color:#000; font-weight:bold; text-decoration: underline;';

                    }else{
                        $active_task = '';
                    }
                    
                    @endphp
                    <div class="row">
                        <div class="col-sm-1">
                            <label class="radio-label">
                                <svg width="16" height="16" class="" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9993 2.6665C8.63555 2.6665 2.66602 8.63604 2.66602 15.9998C2.66602 23.3636 8.63555 29.3332 15.9993 29.3332C23.3631 29.3332 29.3327 23.3636 29.3327 15.9998C29.3327 8.63604 23.3631 2.6665 15.9993 2.6665ZM5.33268 15.9998C5.33268 10.1088 10.1083 5.33317 15.9993 5.33317C21.8904 5.33317 26.666 10.1088 26.666 15.9998C26.666 21.8909 21.8904 26.6665 15.9993 26.6665C10.1083 26.6665 5.33268 21.8909 5.33268 15.9998Z" fill="#71717A"></path>
                                </svg>
                            </label>
                        </div>
                        <div class="col" style="padding-bottom: 1rem;">
                            
                            <a class="text" onclick="updateProgress(@php echo $count_ @endphp)" style="{{ $active_task }}" href="{{ route('send_task') }}?phpid={{$topic->id}}&task={{$task->id}}" id="requirement" >{{ $task->task_name }} </a>
                        </div>
                    </div>        
                    @endif
                </div>

            </div>
            @endforeach
        </ul>
    </div>
    <div class="form-group row">

        
    </div>
    <div style="padding: 20px; max-width: 68%; margin-left:5px;  ">
        <div style="border: 1px solid #ccc; padding: 20px 10px 10px 30px; border-radius: 5px;margin-bottom:40px">
            @php
                if($pdf_reader == 0):
                echo $html_start;
            @endphp
                    
                    
            @php
                else:
            @endphp
            
            <iframe src="{{ asset('php/document/A1_BASIC_PHP/'. $html_start ) }}" style="width: 100%; height: 510px"></iframe></iframe>
            @php
                endif;
            @endphp

        </div>
    </div>

    @if($role == 'teacher')
    <div style="padding: 20px; max-width: 68%; margin-left:5px;  ">
        <div style="border: 1px solid #ccc; padding: 20px 10px 10px 30px; border-radius: 5px;margin-bottom:40px">
        <!-- <a href="{{ asset('/storage/private/febri syawaldi/febri syawaldi_db_conn.php') }}" download>Download File</a>
        <a href="{{public_path('storage/private/febri syawaldi/febri syawaldi_db_conn.php')}}" download>Click me</a> -->


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Download File</th>
                        <!-- Add more table headers as needed -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listTask as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->flag }}</td>
                            <td><a href="{{ asset( $item->path ) }}" download="" class="btn btn-primary">Download File</a></td>
                            <!-- Add more table cells as needed -->
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    @else
        
    @endif
    
    @if($flag == 1)

    <div style="padding: 20px; max-width: 68%; margin-left:5px;  ">
        <div style="border: 1px solid #ccc; padding: 20px 10px 10px 30px; border-radius: 5px;margin-bottom:40px">
            <div style="padding-top: 15px; padding-bottom: 15px">
                <p class='text-list' style='font-size: 24px; font-weight: 600;width: 400px !important;'> Upload File Practicum </p>
                <div class="texts" style=" position: relative;">   
                    <style>    
                        text:hover{
                            text-decoration: none !important;
                        }
                    </style>    
                    <form action="{{ Route("task_submission") }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="phpid" id="phpid" value="{{ $_GET['phpid'] }}">
                        <input type="hidden" name="start" id="start" value="{{ $_GET['start'] }}">
                        <div class="form-group" >
                            <label for="">Evidence</label>
                            <input type="file" name="file" class="form-control">
                            <small>Enter the work results <code>.php | .html </code></small>
                        </div>
                        <br />
                        <div class="form-group">
                            <label for="">Comment</label>
                            <textarea class="form-control" name="comment" placeholder="..."></textarea>
                        </div>
                        <br />
                        <div class="form-group">
                            <input type="submit" value="Upload" class="btn btn-primary">
                        </div>
                        
                        @if($output)
                            <p>{!! $output !!}</p>
                        @else
                            <p>{!! $output !!}</p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
        
    @endif

    


    <!-- Footer -->
    <footer class="footer">
        © 2023 Your Website. All rights reserved.
    </footer>
    
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script type="text/javascript">
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    
                    uploadUrl: '{{route('uploadimage').'?_token='.csrf_token()}}',
                   
                }
            });
    </script>
    <script>
        
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }

        function toggleItem(item) {
            const content = item.nextElementSibling;
            const icon = item.querySelector('.list-item-icon');
            content.style.display = content.style.display === 'block' ? 'none' : 'block';
            icon.style.transform = content.style.display === 'block' ? 'rotate(180deg)' : 'none';
        }

        const radioButtons = document.querySelectorAll('input[name="itemSelection"]');
        const textElements = document.querySelectorAll('.text');

        radioButtons.forEach((button, index) => {
            button.addEventListener('change', () => {
                textElements.forEach((textElement, i) => {
                    if (i === index) {
                        textElement.style.fontWeight = 'bold';
                    } else {
                        textElement.style.fontWeight = 'normal';
                    }
                });
            });
        });
        function move() {
            
            var progressBar = document.getElementById("myProgressBar");
            var progressText = document.getElementById("progressText");
            var width = 0;
            var interval = setInterval(frame, progress);

            function frame() {
            if (width >= progress) {
                clearInterval(interval);
            } else {
                width++;
                progressBar.style.width = width + "%";
                progressText.innerHTML = width + "%";
            }
            }
        }
        move();
        function updateProgress(params) {
            // Get CSRF token from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
            $.ajax({
                type: "POST",
                url: "{{ Route('session_progress') }}",
                data: {params: params},
                success: function(response) { 
                    $('#progressbar').css('width', params + '%');
                   
                }
            });
        }
        $('#progress').text("@php 
                                $width = session('params');
                                echo $width."%"; 
                            @endphp");
    </script>
</body>

</html>

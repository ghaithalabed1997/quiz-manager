@extends('layouts.app')
@section('title', 'Add Questions')
@section('content')

    <!-- /.content-header -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add questions</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Add questions</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Title</h3>

                                    <div class="card-tools">
                                        <a class="btn btn-info btn-sm" href="javascript:;" data-toggle="modal"
                                            data-target="#myModal">Add new</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered table-hover datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Question</th>
                                                <th>ans</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($questions as $key => $question)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $question['questions'] }}</td>
                                                    <td>{{ $question['ans'] }}</td>
                                                    <td><input class="question_status" data-id="{{ $question['id'] }}"
                                                            <?php if ($question['status'] == 1) {
                                                                echo 'checked';
                                                            } ?> type="checkbox" name="status"></td>
                                                    <td>
                                                        <a href="{{ url('admin/update_question/' . $question['id']) }}"
                                                            class="btn btn-primary btn-sm">Update</a>
                                                        <a href="{{ url('admin/delete_question/' . $question['id']) }}"
                                                            class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Question</th>
                                                <th>ans</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content-header -->

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add new Question</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/admin/add_new_question') }}" class="database_operation_with_file_upload"
                            method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Enter Question</label>
                                        {{ csrf_field() }}
                                        <input type="hidden" name="exam_id" value="{{ Request::segment(3) }}">
                                        <input type="text" required="required" name="question"
                                            placeholder="Enter Question" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Enter Option 1</label>
                                        <input type="text" required="required" name="option_1"
                                            placeholder="Enter Question" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Enter Option 2</label>
                                        <input type="text" required="required" name="option_2"
                                            placeholder="Enter Option 2" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Enter Option 3</label>
                                        <input type="text" required="required" name="option_3"
                                            placeholder="Enter  Option 3" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Enter Option 4</label>
                                        <input type="text" required="required" name="option_4"
                                            placeholder="Enter  Option 4" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="flex justify-between items-center w-full">
                                        <label for="">Select correct option</label>
                                        <div>
                                            <select class="form-control" required="required" name="ans">
                                                <option value="">Select</option>

                                                <option value="option_1">option 1</option>
                                                <option value="option_2">option 2</option>
                                                <option value="option_3">option 3</option>
                                                <option value="option_4">option 4</option>

                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="flex flex-row justify-between items-center w-full">
                                        <label>Upload Audio</label>
                                        <div>
                                            <input type="file" name="audio" accept="audio/mpeg" id="audio_input"
                                                class="form-control" onchange="previewFile()">
                                        </div>
                                    </div>
                                </div>

                                <div class="display-none mt-3 p-2"id="audio_input_wrapper">
                                    <audio id="audio_preview" controls style="width: 100%; display: none;"></audio>
                                </div>
                                <div class="py-2" id="recommendation" x-text="showRecommendation" class="ml-2">

                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary">Add</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>



        @endsection
        <script>
            function previewFile() {
                const file = document.getElementById("audio_input").files[0];
                const maxSize = 10 * 1024 * 1024; // 10 MB

                const preview = document.getElementById("audio_preview");
                const wrapper = document.getElementById("audio_input_wrapper");
                const recommendationBox = document.getElementById("recommendation");

                if (!file) return;

                if (file.size > maxSize) {
                    alert("Die Datei ist zu groß. Maximal erlaubt: 10MB.");
                    document.getElementById("audio_input").value = "";
                    return;
                }

                // Preview the audio
                if (file && file.type.startsWith('audio/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        wrapper.style.display = 'block';
                        preview.oncanplaythrough = () => {
                            preview.play().catch(err => console.warn("Autoplay failed:", err));
                        };
                    };

                    reader.readAsDataURL(file);

                    // Transcribe via Whisper API
                    const formData = new FormData();
                    formData.append("audio", file);

                    fetch("/admin/transcribe-audio", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.text) {
                                recommendationBox.innerHTML = `<strong>Recommendation:</strong> ${data.text}`;
                                const optionNames = ['option_1', 'option_2', 'option_3', 'option_4'];
                                const randomIndex = Math.floor(Math.random() * optionNames.length);
                                const selectedOptionName = optionNames[randomIndex];
                                const optionInput = document.querySelector(`input[name="${selectedOptionName}"]`);
                                if (optionInput && !optionInput.value) {
                                    optionInput.value = data.text;
                                }
                            } else {
                                recommendationBox.innerHTML = "No recommendation could be generated.";
                            }

                        })
                        .catch(err => {
                            console.error("Transcription failed:", err);
                            recommendationBox.innerHTML;
                        });
                }
            }
        </script>

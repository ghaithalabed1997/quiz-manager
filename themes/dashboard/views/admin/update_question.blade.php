@extends('layouts.app')
@section('title', 'Update Exam Questions')
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
                            <li class="breadcrumb-item active">Update Exam questions</li>
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

                                </div>
                                <div class="card-body">
                                    <form action="{{ url('/admin/edit_question_inner') }}" class="database_operation">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Enter Question</label>
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" value="{{ $q[0]['id'] }}">
                                                    <input type="text" value="{{ $q[0]['questions'] }}"
                                                        required="required" name="question" placeholder="Enter Question"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <?php
                                            $options = json_decode($q[0]['options']);
                                            ?>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Enter Option 1</label>
                                                    <input type="text" value="{{ $options->option1 }}"
                                                        required="required" name="option_1" placeholder="Enter Question"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Enter Option 2</label>
                                                    <input type="text" value="{{ $options->option2 }}"
                                                        required="required" name="option_2" placeholder="Enter Option 2"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Enter Option 3</label>
                                                    <input type="text" value="{{ $options->option3 }}"
                                                        required="required" name="option_3" placeholder="Enter  Option 3"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Enter Option 4</label>
                                                    <input type="text" value="{{ $options->option4 }}"
                                                        required="required" name="option_4" placeholder="Enter  Option 4"
                                                        class="form-control">
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
                                                        <input type="file" name="audio" accept="audio/mpeg"
                                                            id="audio_input" class="form-control" onchange="previewFile()">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="display-none mt-3 p-2"id="audio_input_wrapper">
                                                <audio id="audio_preview" controls
                                                    style="width: 100%; display: none;"></audio>
                                            </div>
                                            <div class="py-2" id="recommendation" x-text="showRecommendation"
                                                class="ml-2">

                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
                            if (optionInput) {
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

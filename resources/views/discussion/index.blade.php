@extends('layout.mainlayout')

@section('content')
<section class="breadcrumb_part blog_grid_bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 ">
                <div class="breadcrumb_iner">
                    <h2>Messagerie</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="popular_course section_bg section_padding" id="selectStudentSection">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-12 px-0">
                    @if(session()->has('teacher'))
                    <h4>Sélectionnez un étudiant :</h4>
                    <select name="studentMessage" id="studentMessage" class="form-control">
                        @foreach($data['students'] as $student)
                        <option value="{{ $student->id }} ">{{ $student->lastname }} {{ $student->firstname}}</option>
                        @endforeach
                    </select>
                    <br />
                    <br />
                    @endif
                    <div class="px-4 py-5 chat-box" style="max-height:500px !important; overflow-y: scroll;">

                    </div>
                </div>
            </div>
        </div>
</section>
<section class="popular_course section_padding section_bg" id="sendSection">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="POST" id="form">
                    <input type="hidden" id="student_id" name="student_id">
                    <label for="content">{{ $data['labelText'] }}: </label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
                    <br />
                    <button type="submit" class="btn btn-info" value="Envoyer">{{ $data['btnText'] }}</button>
                </form>
                <p class="text-center">
                    <a href="/Registration" class="go_back"> <i class="arrow_back"></i>Retour au dépot de candidature</a>
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        if ('{{ session()->has("student") }}' == '1') {
            if ('{{ $data["canSend"] ?? "false" }}' != 'true') {
                $("#form, #content").remove();
                $(".col-md-12").first().append('<b>En attente de la réponse d\'un professeur.</b>');
            }
            var studentMessages = '{!! $data["studentMessages"] ?? "null" !!}';
            setConversation(JSON.parse(studentMessages), 'asStudent');
        } else {
            if ($("#studentMessage").val() === null) {
                var div = $("#studentMessage").parent();
                div.empty();
                div.append('<i class="fa fa-info-circle"></i>');
                div.append('<p>Il n\'y a pas de message actuellement.</p>');
                $("#studentMessage, #sendSection").remove();
            } else {
                getStudentMessages();
            }
        }

        $("#form").submit(function(e) {
            var form = $(this);
            e.preventDefault();
            $("#student_id").val($("#studentMessage").val());
            $.ajax({
                url: '{{ $data["formAction"] }}',
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                    displayToastr('messageSent');
                    addSendMessage($("#content").val(), data.messageDate);
                    $("#form, #content").hide();
                },
                error: function(xhr, status, error) {
                    $("#form, #content").hide();
                    if (xhr.responseJSON.message == 'noMessageFound') {
                        displayToastr('errorMsg', 'Vous avez répondus à tout les messages !');
                    } else {
                        displayToastr('error');
                    }
                },
            });
        });

        $("#studentMessage").change(function() {
            getStudentMessages();
        });

        function getStudentMessages(studentId) {
            $.ajax({
                url: '/Discussion/GetStudentMessage',
                type: 'GET',
                data: {
                    studentId: $("#studentMessage").val()
                },
                success: function(data) {
                    displayToastr('messageLoaded');
                    setConversation(data, 'asTeacher');
                    if ($(".media").last().hasClass('responseContent')) {
                        $("#form, #content").hide();
                        $(".col-md-12").find('b').remove();
                        $(".col-md-12").first().append('<b>En attente d\'un message de l\'élève.</b>');
                    } else {
                        $("#form, #content").show();
                        $(".col-md-12").find('b').remove();

                    }
                },
                error: function(xhr, status, error) {
                    form.find(":submit").prop('disabled', false);
                },
            });
        }

        function setConversation(messages, asWho) {
            $(".chat-box").empty();
            $(messages).each(function(idx, message) {
                setMessage(message, asWho);
            });

            $('.chat-box').animate({
                scrollTop: $('.chat-box').get(0).scrollHeight
            }, 2000);
        }

        function setMessage(message, asWho) {
            if (asWho == 'asTeacher') {
                var tmpMessage = message.messageContent;
                message.messageContent = message.responseContent;
                message.responseContent = tmpMessage;

                var tmpDate = message.messageDate;
                message.messageDate = message.responseDate;
                message.responseDate = tmpDate;

                addResponseMessage(message.responseContent, message.responseDate);
                addSendMessage(message.messageContent, message.messageDate);

            } else {
                addSendMessage(message.messageContent, message.messageDate);
                addResponseMessage(message.responseContent, message.responseDate);
            }
        }

        function addSendMessage(messageContent, messageDate) {
            if (messageContent != null) {
                var message =
                    '<div class="media w-50 ml-auto mb-3 responseContent">' +
                    '    <div class="media-body">' +
                    '        <div class="bg-primary rounded py-2 px-3 mb-2">' +
                    '            <p class="text-small mb-0 text-white">' + messageContent + '</p>' +
                    '        </div>' +
                    '        <p class="small text-muted">' + moment(messageDate).format('DD MMMM | HH:mm') + '</p>' +
                    '    </div>' +
                    '</div>';
                $(".chat-box").append(message);
            }
        }

        function addResponseMessage(responseContent, responseDate) {
            if (responseContent != null) {
                var message =
                    '<div class="media w-50 mb-3">' +
                    '   <div class="media-body ml-3">' +
                    '     <div class="rounded py-2 px-3 mb-2" style="background-color:#C1B9B8">' +
                    '       <p class="text-small mb-0 text-white">' + responseContent + '</p>' +
                    '     </div>' +
                    '        <p class="small text-muted">' + moment(responseDate).format('DD MMMM | HH:mm') + '</p>' +
                    '   </div>' +
                    ' </div>';
                $(".chat-box").append(message);
            }
        }
    });
</script>

@endsection
<?= $this->draw('entity/edit/header'); ?>
<?php

    $autosave = new \Idno\Core\Autosave();
    if (!empty($vars['object']->body)) {
        $body = $vars['object']->body;
    } else {
        $body = $autosave->getValue('entry', 'bodyautosave');
    }
    if (!empty($vars['object']->title)) {
        $title = $vars['object']->title;
    } else {
        $title = $autosave->getValue('entry', 'title');
    }

    /* @var \Idno\Core\Template $this */

?>
    <form action="<?= $vars['object']->getURL() ?>" method="post">

        <div class="row">

            <div class="span8 offset2 edit-pane">


                <?php

                    if (empty($vars['object']->_id)) {

                        ?>
                        <h4>New Post</h4>
                    <?php

                    } else {

                        ?>
                        <h4>Edit Post</h4>
                    <?php

                    }

                ?>
                <p>
                    <label>
                        Title<br/>
                        <input type="text" name="title" id="title" placeholder="Give it a title"
                               value="<?= htmlspecialchars($title) ?>" class="span8"/>
                    </label>
                </p>

                <p>
                    <label>
                        Body<br/>
                        <textarea name="body"  placeholder="Tell your story"
                                  class="span8 bodyInput mentionable wysiwyg" id="body"><?= (htmlspecialchars($this->autop($body))) ?></textarea>
                    </label>
                </p>
                <?= $this->draw('entity/tags/input'); ?>
                <?php if (empty($vars['object']->_id)) echo $this->drawSyndication('article'); ?>

                <div class="wordcount" id="result">
                    Total words <strong><span id="totalWords">0</span></strong>
                </div>

                <p class="button-bar ">
                    <?= \Idno\Core\site()->actions()->signForm('/entry/edit') ?>
                    <input type="button" class="btn btn-cancel" value="Cancel" onclick="hideContentCreateForm();"/>
                    <input type="submit" class="btn btn-primary" value="Publish"/>
                    <?= $this->draw('content/access'); ?>
                </p>

            </div>

        </div>
    </form>
    <div id="bodyautosave" style="display:none"></div>
    <script>

        /*function postForm() {
         var content = $('textarea[name="body"]').html($('#body').html());
         console.log(content);
         return content;
         }*/

        counter = function () {

            var value = $('#body').code(); // $('#body').val();
            if (value.length == 0) {
                $('#totalWords').html(0);
                $('#totalChars').html(0);
                $('#charCount').html(0);
                $('#charCountNoSpace').html(0);
                return;
            }

            var regex = /\s+/gi;
            var wordCount = value.trim().replace(regex, ' ').split(' ').length;
            var totalChars = value.length;
            var charCount = value.trim().length;
            var charCountNoSpace = value.replace(regex, '').length;

            $('#totalWords').html(wordCount);
            $('#totalChars').html(totalChars);
            $('#charCount').html(charCount);
            $('#charCountNoSpace').html(charCountNoSpace);
        };

        $(document).ready(function () {
            $('#body').change(counter);
            $('#body').keydown(counter);
            $('#body').keypress(counter);
            $('#body').keyup(counter);
            $('#body').blur(counter);
            $('#body').focus(counter);
            setInterval(function() {
                $('#bodyautosave').val($('#body').code());
            },10000);
        });

        $(document).ready(function () {
            $('.wysiwyg').summernote({
                height: "15em",
                airMode: false,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fancy', ['link', 'picture']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['codeview', ['fullscreen', 'codeview']]
                ],
                onkeyup: counter,
                onImageUpload: function (files, editor, welEditable) {
                    uploadFileAsync(files[0], editor, welEditable);
                }
            });
        });

        function uploadFileAsync(file, editor, welEditable) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "<?=\Idno\Core\site()->config()->getDisplayURL()?>file/upload/",
                cache: false,
                contentType: false,
                processData: false,
                success: function (url) {
                    editor.insertImage(welEditable, url);
                }
            });
        }

        // Autosave the title & body
        autoSave('entry', ['title', 'bodyautosave']);
    </script>
<?= $this->draw('entity/edit/footer'); ?>
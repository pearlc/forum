<!-- (s) freeboard -->

<div class="board_header">
    <h4><a href="freeboard/"><?=$this->lang->line('common_label_freeboard');?></a></h4>
</div>

<div class="wrap_editor">
    <?php echo form_open($this->uri->uri_string()) ?>
        <dl>
            <dt>제목</dt>
            <dd>
                <input type="text" name="title" value="<?=$title?>" />
            </dd>
        </dl>
        <dl>
            <dt>내용</dt>
            <dd>
                <textarea name="ckeditor"><?=$content?></textarea>
                <script>
                    CKEDITOR.replace( 'ckeditor' );
                </script>
            </dd>
        </dl>
        <dl>
            <dt></dt>
            <dd>
                <input type="submit" value="완료">
            </dd>
        </dl>
    <?php echo form_close();?>
</div>
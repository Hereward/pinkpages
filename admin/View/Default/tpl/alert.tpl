{if $alert_msg}
<div class="er-message">
    <div class="er-image"><img src="{$IMAGES_PATH}alert.png" style="vertical-align:middle; alt=""  /></div>
    <div class="er-content">
        <ul>
            <li>{$alert_msg}</li>
        </ul>
    </div>
</div>
{elseif $alert_msg_succ}
<div class="er-message-success">
    <div class="er-content">
        <ul>
            <li>{$alert_msg_succ}</li>
        </ul>
    </div>
</div>
{/if}
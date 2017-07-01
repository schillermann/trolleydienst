<?php
$recipient_all = ($placeholder['recipient'] == Enum\Recipient::ALL)? 'selected' : '';
$recipient_literature_table = ($placeholder['recipient'] == Enum\Recipient::LITERATURE_TABLE)? 'selected' : '';
$recipient_literature_cart = ($placeholder['recipient'] == Enum\Recipient::LITERATURE_CART)? 'selected' : '';
?>
<h2>Mail-Versand</h2>
<?php if (isset($placeholder['message'])) : ?>
    <div class="note-box">
        <?php if (isset($placeholder['message']['success'])): ?>
        <p class="success">
            <?php echo $placeholder['message']['success']; ?>
            <table>
            <?php foreach ($placeholder['user_list'] as $user): ?>
                <tr>
                    <td><?php echo $user['firstname']; ?> <?php echo $user['lastname']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                </tr>
            <?php endforeach; ?>
            </table>
        </p>
        <?php else: ?>
        <p class="error">
            <?php echo $placeholder['message']['error']; ?>
        </p>
        <?php endif;?>
    </div>
<?php endif;?>

<form method="post">
    <fieldset>
        <legend>Mail</legend>

        <div>
            <label for="recipient">Empfänger</label>
            <select id="subject" name="recipient" tabindex="1">
                <option value="<?php echo Enum\Recipient::ALL; ?>" <?php echo $recipient_all; ?>>Alle</option>
                <option value="<?php echo Enum\Recipient::LITERATURE_TABLE; ?>" <?php echo $recipient_literature_table; ?>>Infostand</option>
                <option value="<?php echo Enum\Recipient::LITERATURE_CART; ?>" <?php echo $recipient_literature_cart; ?>>Trolley</option>
            </select>
        </div>
        <div>
            <label for="subject">Betreff <small>(Pflichtfeld)</small></label>
            <input id="subject" type="text" name="subject" tabindex="2" required value="<?php echo $placeholder['subject']; ?>">
        </div>
        <div>
            <label for="text">Text <small>(Pflichtfeld)</small></label>
            <textarea id="text" name="text" tabindex="3" rows="20" required><?php echo $placeholder['text'];?></textarea>
        </div>

    </fieldset>
    <div class="from-button">
        <button type="submit" name="send" class="active" tabindex="4">
            <i class="fa fa-paper-plane" aria-hidden="true"></i> Senden
        </button>
    </div>
</form>

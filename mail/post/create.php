<?php
/**
 * @var string $name
 * @var string $message
 * @var string $editLink
 * @var string $deleteLink
 */
?>

<h1>Hello, <?= htmlspecialchars($name) ?>!</h1>
<p>Your post has been created successfully.</p>
<p><strong><?= htmlspecialchars($message) ?></strong></p>

<p>To manage the post, follow the <a href="<?= $editLink ?>">link</a>.</p>

<p>Thank you for using our service!</p>

<div class="stockMarquee border-bottom">
    <div class="stockMarquee__list">
        <?php
        $file = 'https://pub-2e0173a957144017abb3d9b4ce47c176.r2.dev/dse/data_dump.json?v=' . time();
        $data = file_get_contents($file);
        $result = json_decode($data, true);
        ?>

        <?php foreach ($result as $item) { ?>
        <?php
        if (str_contains($item['change'], '-')) {
            $stCls = 'down-arrow';
        } elseif ($item['change'] == '0' || $item['change'] == '০') {
            $stCls = 'updown-arrow';
        } else {
            $stCls = 'up-arrow';
        }
        ?>

        <div class="stockMarquee__item">
            <a target="_blank" href="https://www.dsebd.org/displayCompany.php?name=<?php echo $item['trading_code']; ?>"
                class="<?php echo $stCls; ?>">
                <div class="stock-container">
                    <div class="stock-main">
                        <div class="stock-name"><?php echo $item['trading_code']; ?></div>
                        <div class="stock-price"><?php echo $item['last_trading_price']; ?></div>
                    </div>
                    <div class="stock-info">
                        <div class="change-value">
                            <div class="arrow">
                                <?php
                                if (str_contains($item['change'], '-')) {
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293z"/></svg>';
                                } elseif ($item['change'] == '0' || $item['change'] == '০') {
                                    //echo '<img src="./img/tkupdown.gif" alt="up arrow" class="stock-stockMarquee-item-arrow">';
                                } else {
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-square" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm8.5 9.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707z"/></svg>';
                                }
                                ?>
                            </div>
                            <?php echo $item['change']; ?>
                        </div>
                        <div class="change-percent"><?php echo $item['change_percent']; ?></div>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        var stockMarquee = document.querySelector('.stockMarquee'),
            list = document.querySelector('.stockMarquee__list'),
            clone = list.cloneNode(true)

        stockMarquee.append(clone)
    });
</script>

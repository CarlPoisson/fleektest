<html>
    <head>
        <title>BSCSCAN TESTS</title>
    </head>
    <body>
        <?php

        // Vars
        $bsc_api_key = 'ENXK7SN6SD4TI5XWG1M4F9SZCFPAD397SG';
        $wallet_address = '0x037FB1D67e0f8c08184c865Dc5202489a2b31f02';

        // Token addresses
        $bnb = '0xbb4cdb9cbd36b01bd1cbaebf2de08d9173bc095c';
        $seedify = '0x477bc8d23c634c154061869478bce96be6045d12';
        $twep = '0x1aeb3f66d96bfaf74fcbd15dc21798de36f6f933';
        $golddoge_sachs = '0x301c565e1114452eb8237f8ba837e2c846393fa1';
        $galactic_quadrant = '0xf700d4c708c2be1463e355f337603183d20e0808';
        $metawear = '0x9d39ef3bbca5927909dde44476656b81bbe4ee75';
        $amazy = '0x7b665b2f633d9363b89a98b094b1f9e732bd8f86';
        $spintop = '0x6aa217312960a21adbde1478dc8cbcf828110a67';

        // Contract to lookup
        $token_contract = $bnb;


        // CURL requests
        function get_data($request,$type) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            $data = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($data, true);
            echo '<pre>';
            print_r($result);
            echo '</pre>';
            if ( $type == 'balance' ) {
                return $result['result'] / 1000000000000000000; // Convert wei to bsc
            }
            if ( $type == 'price' ) {
                return $result['data'];
            }
        }

        // Get balance (BSCSCAN API REQUEST)
        $bsccan_token_balance = 'https://api.bscscan.com/api?module=account&action=tokenbalance&contractaddress=' . $token_contract . '&address=' . $wallet_address . '&tag=latest&apikey=' . $bsc_api_key;

        // Get token details (PANCAKESWAP API REQUEST)
        $pcs_endpoint = 'https://api.pancakeswap.info/api/v2/';
        $pcs_get_token_info = 'tokens/';
        $pcs_price_request = $pcs_endpoint . $pcs_get_token_info . $token_contract;

        // Details
        $tokenBalance = get_data($bsccan_token_balance, 'balance');
        $tokenDetails = get_data($pcs_price_request, 'price');
        $tokenValue = $tokenBalance * $tokenDetails['price'];

        ?>

        <div class="tokenInfo">
            <p class="tokenName">Token Name <span><?= $tokenDetails['name']; ?></span></p>
            <p class="tokenSymbol">Token Symbol <span><?= $tokenDetails['symbol']; ?></span></p>
            <p class="tokenBalance">Token Balance <span><?= round( $tokenBalance, 0 ); ?></span></p>
            <p class="tokenPrice">Token Price <span><?= round( $tokenDetails['price'], 6 ); ?></span></p>
            <p class="tokenValue">Token Value <span><?= round( $tokenValue, 2 ); ?></span></p>
        </div>

        <style>
            body {
                font-family: 'Open Sans', sans-serif;
                font-size: 14px;
                color: #333;
                background-color: #fff;
            }
            .tokenInfo {
                border: 1px solid #999;
                max-width: 260px;
                width: 100%;
                text-align: center;
                margin-top: 20px;
            }
            .tokenInfo p {
                display: flex;
                justify-content: space-between;
                margin: 10px;
            }
            .tokenInfo p span {
                font-family: 'Courier New', monospace;';
                font-weight: 700;
            }
        </style>



    </body>
</html>
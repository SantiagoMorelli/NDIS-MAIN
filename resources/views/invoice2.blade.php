<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            text-indent: 0
        }

        .m_s1 {
            color: #c1d642;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 18pt
        }

        .m_s3 {
            color: #2f4977;
            font-family: Arial, sans-serif;
            font-style: italic;
            font-weight: normal;
            text-decoration: none;
            font-size: 15pt
        }

        h1 {
            color: #2f4977;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 41pt
        }

        .m_s4 {
            color: #2f4977;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 12pt
        }

        .m_s5 {
            color: #2a2a28;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 12pt
        }

        h3 {
            color: #2f4977;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 22.5pt
        }

        .m_s6 {
            color: #2f4977;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 12pt
        }

        h4 {
            color: #2f4977;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 14pt
        }

        p {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 12pt;
            margin: 0pt
        }

        .m_s7 {
            color: #2f4977;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 12pt
        }

        .m_s8 {
            color: #fff;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 12pt
        }

        .m_s9 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 12pt
        }

        .m_s10 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 12pt
        }

        .m_s12 {
            color: #c1d846;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 12pt
        }

        .m_a {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 12pt
        }

        .m_s13 {
            color: #2f4977;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: underline;
            font-size: 12pt
        }

        h2 {
            color: #c1d846;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 31pt
        }

        .m_s14 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 12pt
        }

        table,
        tbody {
            vertical-align: top;
            overflow: visible
        }
    </style>
</head>

<body>








    <div>
        <div class="container" style=" width:800px;">
            <div class="logo" style="float: left;width:285px;height:270px;">
                <img src="https://www.bettercaremarket.com.au/static/version1677227341/frontend/Magento/subsetalothemes/en_AU/images/logo-mobile.svg"
                    alt="" style="width: 140px;margin-left: 70px;margin-top:20px; ">
                <div class="betterCare">
                    <p class="m_s1"
                        style="
                            padding-top: 4pt; 
                            text-indent: 0pt;
                            text-align: center;
                          ">
                        better<span style="color: #1a3664">care</span>market
                    </p>
                    <div class="reimage">
                        <p class="m_s3"
                            style="
                                padding-top: 1pt;
                                text-indent: 0pt;
                                text-align: center;
                                letter-spacing: 2px;
                              ">
                            Reimagine Better Living
                        </p>
                    </div>
                </div>
            </div>
            <div class="Invoice" style="float:right;  margin-left:210px;width:390px;height:270px; ">
                <h1
                    style="
                padding-top: 3pt; 
                text-indent: 0pt;
                text-align: left;
                letter-spacing: 6;
                
              ">
                    {{ $document_type }}
                </h1>
                <br>
                <br>

                <p class="m_s4"
                    style="
                        float:left;
                  width:200px;
                  padding-top: 2pt;
                  text-indent: 0pt;
                  text-align: left;
                  margin-left:20px;
                
                margin-top:-50px;
                ">
                    DATE:
                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:260px; width:90px;text-align: right;">{{ $date }}</span>



                <p class="m_s4"
                    style="
                        float:left;
                  width:200px;
                  padding-top: 2pt;
                  text-indent: 0pt;
                  text-align: left;
                  margin-left:20px;
                
                ">
                    INVOICE NO:
                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:260px; width:90px;text-align: right;">{{ $invoiceNro }}</span>

                <h3
                    style="
                  margin-left:20px;
                    text-indent: 0pt;
                    text-align: left;
                    width: 100%;
                    margin-top: 10px;

                  ">
                    {{ $Attn }}
                </h3>
                <p
                    style="
                
                text-indent: 0pt;
                text-align: left;
                margin-left:20px;
              ">
                    <a href="mailto:accounts@myplanmanager.com.au" class="m_s6">{{ $AttnEmail }}</a>
                </p>


            </div>
            <div
                style="
            height: 2px;
            background-color: #DFEBA3;
            width: 800px;
        ">

            </div>
            <div style="float: left;width:325px;height:150px;">
                <h4
                    style="
                padding-top: 10pt;
                text-indent: 0pt;
                text-align: left;
                letter-spacing: 3px;
                margin-bottom: 10px;
              ">
                    PAYMENT METHOD
                </h4>

                <p
                    style="
                        float:left;
                  width:100px;
                  text-indent: 0pt;
                  text-align: left;
                padding-top: 1pt; 
                line-height: 109%;
                
              
                
                ">
                    ACCT NO:
                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:250px; width:90px;text-align: right;">{{ $paymentAcct }}</span>

                <p
                    style="
                        float:left;
                  width:100px;
                  text-indent: 0pt;
                  text-align: left;
                padding-top: 1pt; 
                line-height: 109%;
                
              
                
                ">
                    BSB:
                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:250px; width:90px;text-align: right;">{{ $paymentBsb }}</span>

                <p
                    style="
                        float:left;
                  width:100px;
                  text-indent: 0pt;
                  text-align: left;
                padding-top: 1pt; 
                line-height: 109%;
                
              
                
                ">
                    ACCT NAME:
                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:250px; width:90px;text-align: right;">{{ $paymentAcctName }}</span>
                <p
                    style="
                        float:left;
                  width:200px;
                  text-indent: 0pt;
                  text-align: left;
                padding-top: 1pt; 
                line-height: 109%;
                
              
                
                ">

                </p>
                <span class="m_s5" style=" float:right;  margin-left:250px; width:90px;text-align: right;"></span>

            </div>
            <div style="float:right;  margin-left:230px;width:325px;height:150px;">
                <h4
                    style="
            padding-top: 10pt;
            text-indent: 0pt;
            text-align: left;
            letter-spacing: 3px;
            margin-bottom: 10px;
          ">
                    CUSTOMER DETAILS
                </h4>

                <p
                    style="
                    float:left;
              width:100px;
              text-indent: 0pt;
              text-align: left;
            padding-top: 1pt; 
            line-height: 109%;
            
          
            
            ">
                    Name:
                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:250px; width:90px;text-align: right;">{{ $customerName }}</span>

                <p
                    style="
                    float:left;
              width:100px;
              text-indent: 0pt;
              text-align: left;
            padding-top: 1pt; 
            line-height: 109%;
            
          
            
            ">
                    NDIS No:
                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:250px; width:90px;text-align: right;">{{ $customerNdis }}</span>

                <p
                    style="
                    float:left;
              width:100px;
              text-indent: 0pt;
              text-align: left;
            padding-top: 1pt; 
            line-height: 109%;
            
          
            
            ">
                    DoB:
                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:250px; width:90px;text-align: right;">{{ $customerDob }}</span>

                <p
                    style="
                    float:left;
              width:100px;
              text-indent: 0pt;
              text-align: left;
            padding-top: 1pt; 
            line-height: 109%;
            
          
            
            ">
                    Address:
                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:250px; width:90px;text-align: right;">{{ $customerStreetName }}
                </span>
                <p
                    style="
                float:left;
          width:100px;
          text-indent: 0pt;
          text-align: left;
        padding-top: 1pt; 
        line-height: 109%;
        
      
        
        ">

                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:250px; width:90px;text-align: right;">{{ $customerSuburb }}
                </span>
                <p
                    style="
            float:left;
      width:100px;
      text-indent: 0pt;
      text-align: left;
    padding-top: 1pt; 
    line-height: 109%;
    
  
    
    ">

                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:250px; width:90px;text-align: right;">{{ $customerPostcode }}
                </span>

                <p
                    style="
                    float:left;
              width:100px;
              text-indent: 0pt;
              text-align: left;
            padding-top: 1pt; 
            line-height: 109%;
            
          
            
            ">
                    Phone:
                </p>
                <span class="m_s5"
                    style=" float:right;  margin-left:250px; width:90px;text-align: right;">{{ $customerPhone }}</span>

                <p
                    style="
                    float:left;
              width:200px;
              text-indent: 0pt;
              text-align: left;
            padding-top: 1pt; 
            line-height: 109%;
            
          
            
            ">

                </p>
                <span class="m_s5" style=" float:right;  margin-left:250px; width:90px;text-align: right;"></span>


            </div>


            <div style="width:700px;margin-top:40px">

                <table style="border-collapse:collapse;margin-left:7.022pt" cellspacing="0">
                    <tbody>
                        <tr style="height:35pt">
                            <td style="width:228pt " bgcolor="#1C3462">
                                <p class="m_s8"
                                    style="padding-top:10pt;padding-left:78pt;text-indent:0pt;text-align:left">PRODUCT
                                    NAME</p>
                            </td>
                            <td style="width:20pt" bgcolor="#1C3462">
                                <p class="m_s8" style="padding-top:10pt;text-indent:0pt;text-align:center">
                                    QTY</p>
                            </td>
                            <td style="width:76pt" bgcolor="#1C3462">
                                <p class="m_s8"
                                    style="padding-top:10pt;padding-left:15pt;padding-right:15pt;text-indent:0pt;text-align:center">
                                    PRICE</p>
                            </td>
                            <td style="width:75pt" bgcolor="#1C3462">
                                <p class="m_s8"
                                    style="padding-top:10pt;padding-left:15pt;padding-right:33pt;text-indent:0pt;text-align:center">
                                    GST</p>
                            </td>
                            <td style="width:27pt" bgcolor="#1C3462">
                                <p class="m_s8" style="padding-top:10pt;text-indent:0pt;text-align:left">TOTAL</p>
                            </td>
                        </tr>
                        @foreach ($products as $key => $product)
                            <tr style="height:35pt">
                                <td style="width:228pt" @if ($key % 2 != 1) bgcolor="#DFEBA3" @endif>
                                    <p class="m_s9"
                                        style="padding-top:10pt;padding-left:10pt;text-indent:0pt;text-align:left">
                                        {{ $product['product_name'] }}</p>
                                </td>
                                <td style="width:40pt" @if ($key % 2 != 1) bgcolor="#DFEBA3" @endif>
                                    <p class="m_s9"
                                        style="padding-top:10pt;padding-left:30pt;text-indent:0pt;text-align:center">
                                        {{ $product['product_quantity'] }} </p>
                                </td>
                                <td style="width:76pt" @if ($key % 2 != 1) bgcolor="#DFEBA3" @endif>
                                    <p class="m_s9"
                                        style="padding-top:10pt;padding-left:15pt;padding-right:15pt;text-indent:0pt;text-align:center">
                                        ${{ $product['product_price'] }}</p>
                                </td>
                                <td style="width:75pt" @if ($key % 2 != 1) bgcolor="#DFEBA3" @endif>
                                    <p class="m_s9"
                                        style="padding-top:10pt;padding-left:15pt;padding-right:29pt;text-indent:0pt;text-align:center">
                                        --</p>
                                </td>
                                <td style="width:67pt" @if ($key % 2 != 1) bgcolor="#DFEBA3" @endif>
                                    <p class="m_s9"
                                        style="padding-top:10pt;padding-left:1pt;text-indent:0pt;text-align:left">
                                        ${{ $product['product_Total'] }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach

                        <tr style="height:46pt">
                            <td style="width:300pt;" colspan="4">
                                <p style="text-indent:0pt;text-align:left"><br></p>
                                <p class="m_s9" style="text-indent:0pt;line-height:14pt;text-align:right">
                                    Subtotal
                                </p>
                            </td>
                            <td style="width:67pt">
                                <p style="text-indent:0pt;text-align:left"><br></p>
                                <p class="m_s9"
                                    style="padding-right:2pt;text-indent:0pt;line-height:14pt;text-align:right">
                                    ${{ $subtotal }}
                                </p>
                            </td>
                        </tr>

                        <tr style="height:15pt">
                            <td style="width:46pt" colspan="4">
                                <p class="m_s9" style="text-indent:0pt;line-height:14pt;text-align:right">Shipping
                                    &amp; Handling</p>
                            </td>
                            <td style="width:67pt">
                                <p class="m_s9"
                                    style="padding-right:2pt;text-indent:0pt;line-height:14pt;text-align:right">
                                    ${{ $shippingAndHandling }}
                                </p>
                            </td>
                        </tr>

                        <tr style="height:16pt">
                            <td style="width:40pt" colspan="4">
                                <p class="m_s9" style="text-indent:0pt;line-height:14pt;text-align:right">10% GST
                                </p>
                            </td>
                            <td style="width:67pt">
                                <p class="m_s9"
                                    style="padding-right:2pt;text-indent:0pt;line-height:14pt;text-align:right">
                                    ${{ $Gst }}
                                </p>
                            </td>
                        </tr>

                        <tr style="height:15pt">
                            <td style="width:40pt" colspan="4">
                                <p class="m_s10" style="text-indent:0pt;line-height:13pt;text-align:right">GRAND
                                    TOTAL</p>
                            </td>
                            <td style="width:67pt">
                                <p class="m_s10"
                                    style="padding-right:2pt;text-indent:0pt;line-height:13pt;text-align:right">
                                    ${{ $grandTotal }}
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <p
                style="padding-top:4pt;padding-left:8pt;text-indent:0pt;line-height:109%;text-align:left;margin-top:20px">
                Once
                we have received
                the full amount of <b>${{ $grandTotal }} </b>in our bank account, we will process the order.</p>




            <div class="logo" style="float: left;width:325px;height:150px">
                <p class="m_s12" style="padding-left:8pt;text-indent:0pt;text-align:left;margin-top:20px">Questions?
                </p>
                <p style="padding-top:3pt;padding-left:8pt;text-indent:0pt;line-height:123%;text-align:left"><a
                        href="mailto:customercare@bettercaremarket.com.au" class="m_a" target="_blank"
                        rel="noreferrer">Email us at customercare@bettercaremarket.<wbr>com.a</a><a
                        href="https://www.google.com/url?q=http://www.bettercarendis.com.au/&amp;source=gmail-html&amp;ust=1678248054583000&amp;usg=AOvVaw1qZKeMiHoG41dyZEDPbTdw"
                        class="m_a" target="_blank" rel="noreferrer">u or call us at 1300 172 151 </a><a
                        href="https://www.google.com/url?q=http://www.bettercarendis.com.au/&amp;source=gmail-html&amp;ust=1678248054583000&amp;usg=AOvVaw1qZKeMiHoG41dyZEDPbTdw"
                        class="m_s13" target="_blank" rel="noreferrer">www.bettercarendis.com.au</a></p>
            </div>
            <div class="Invoice" style="float:right;  margin-left:230px;width:325px;height:100px;">
                <h2 style="padding-top:5pt;padding-left:40pt;line-height:113%;text-align:left">THANK YOU!</h2>
            </div>
            <div style="
    height: 2px;
    background-color: #DFEBA3;
    width: 800px;
">

            </div>
            <p class="m_s14" style="padding-top:5pt;padding-left:24pt;text-indent:0pt;text-align:left">63 Christie
                Street, St. Leonards, 2065, New South Wales - <b>ABN: 96631530893</b></p>
        </div>
    </div>



</body>

</html>

        <div id="detail">
          <form action=" " method="post" enctype="multipart/form-data" name="orderform" id="orderform">
<?php
echo $this->element('product_table',array($product),TRUE);
debug($collection);
?>
              <table>
                            <tr>
                <td class="table_heading"></td>
                <td valign="bottom" class="table_heading"><div align="right"><a href="#options"><img src="../gal_nav_images/m_options.jpg" width="64" height="20" border="0"></a></div></td>
                <td class="option_pop"><div align="right"><span class="pkoptions"> <span class="style2">Ruled journal option <br>
                    </span>
                          <select name="rules_c" size="1" id="rules_c">
                            <
                            <option value="" SELECTED>Select ruling</option>
                            <option value="1/4 rule" >1/4&quot; rule (normal)</option>
                            <option value="1/4 grid" >1/4&quot; grid (normal)</option>
                            <option value="1/5 rule" >1/5&quot; rule (narrow)</option>
                            <option value="1/5 grid" >1/5&quot; grid (narrow)</option>
                            <option value="5/32 rule" >5/32&quot; rule (wide)</option>
                            <option value="5/32 grid" >5/32 grid (wide)</option>
                            <option value="Other ruling" >Other ruling</option>
                          </select>
                </span></div></td>
                <td valign="bottom" class="table_heading"><div align="right"><a href="#options"><img src="../gal_nav_images/m_options.jpg" width="64" height="20" border="0"></a></div></td>
                <td class="option_pop"><div align="right"><span class="pkoptions"> <span class="style2">Ruled journal option <br>
                    </span>
                          <select name="rules_l" size="1" id="rules_l">
                            <
                            <option value="" SELECTED>Select ruling</option>
                            <option value="1/4 rule" > 1/4&quot; rule (normal) </option>
                            <option value="1/4 grid" > 1/4&quot; grid (normal) </option>
                            <option value="1/5 rule" > 1/5&quot; rule (narrow) </option>
                            <option value="1/5 grid" > 1/5&quot; grid (narrow) </option>
                            <option value="5/32 rule" > 5/32&quot; rule (wide) </option>
                            <option value="Other ruling" > Other ruling</option>
                          </select>
                </span></div></td>
              </tr>
              <tr>
                <td height="47" class="table_heading"></td>
                <td colspan="2" valign="top" class="option_pop"><div align="right"><span class="style2">Quarter bound material selection <br>
                    </span>
                        <select name="leather_c" size="1" id="leather_c">
                          <
                          <option value="" SELECTED>Choose leather</option>
                          <option value="black" >Black</option>
                          <option value="chocolate" >Chocolate</option>
                          <option value="rich brown" >Rich brown</option>
                          <option value="saddle tan" >Saddle tan</option>
                          <option value="chestnut" >Chsetnut</option>
                          <option value="dark blue" >Dark blue</option>
                          <option value="dark green" >Dark Green</option>
                          <option value="Burgundy" >Burgundy</option>
                          <option value="crimson" >Crimson</option>
                          <option value="terra cotta" >Terra cotta</option>
                          <option value="grey" >Grey</option>
                          <option value="bright blue" >Bright blue</option>
                          <option value="beige" >Beige</option>
                          <option value="light blue" >Light blue</option>
                          <option value="olive green" >Olive green</option>
                        </select>
                        <select name="cloth" size="1" id="cloth">
                          <
                          <option value="" SELECTED>Choose cloth</option>
                          <option value="mohair black" >Mohair black</option>
                          <option value="mohair green" >Mohair green</option>
                          <option value="mohair blue" >Mohair blue</option>
                          <option value="mohair red" >Mohair red</option>
                          <option value="tan" >Tan</option>
                          <option value="olive green" >Olive green</option>
                          <option value="Burgundy" >Burgundy</option>
                          <option value="forest green" >Forest green</option>
                          <option value="red slub" >Red slub</option>
                          <option value="black slub" >Black slub</option>
                          <option value="mohair brown" >Mohair brown</option>
                          <option value="dark taupe" >Dark taupe</option>
                          <option value="green slub" >Green slub</option>
                        </select>
                </div></td>
                <td colspan="2" valign="top" class="option_pop"><div align="right"><span class="style2">Full leather material selection <br>
                    </span>
                        <select name="leather_l" size="1" id="leather_l">
                          <
                          <option value="" SELECTED>Choose leather</option>
                          <option value="black" >Black</option>
                          <option value="chocolate" >Chocolate</option>
                          <option value="rich brown" >Rich brown</option>
                          <option value="saddle tan" >Saddle tan</option>
                          <option value="chestnut" >Chsetnut</option>
                          <option value="dark blue" >Dark blue</option>
                          <option value="dark green" >Dark Green</option>
                          <option value="Burgundy" >Burgundy</option>
                          <option value="crimson" >Crimson</option>
                          <option value="terra cotta" >Terra cotta</option>
                          <option value="grey" >Grey</option>
                          <option value="bright blue" >Bright blue</option>
                          <option value="beige" >Beige</option>
                          <option value="light blue" >Light blue</option>
                          <option value="olive green" >Olive green</option>
                        </select>
                </div></td>
              </tr>
              <tr>
                <td colspan="5" valign="top" class="table_name"><div align="right"> <span class="style4"></span>
                                                <a href=""> <img src="../gal_nav_images/reset.jpg" name="Reset" border="0" ></a> <span class="style5">
                                                </span>
                        <input type="image" src="../gal_nav_images/update.jpg" name="reset" value="update" onClick="document.orderform.action='';document.orderform.submit();">
                        Courtesy Quote: $0    <span class="style5">..</span> <span class="style5"> </span>
                        <input type="image" src="../gal_nav_images/cart.jpg" name="addtocart" value="addtocart" onClick="document.orderform.action='pp_stepstone.php';document.orderform.submit();">
                        <br>
                        <span class="style5"></span> <span class="style5">
                        <input type="hidden" name="cmd" value="_cart">
                        <input type="hidden" name="business" value="ddrake@dreamingmind.com">
                        <input type="hidden" name="display" value="1">
                        <input type="image" img src="../gal_nav_images/checkout.jpg" name="seecart" value="seecart" onClick="document.orderform.action='https://www.paypal.com/cgi-bin/webscr';document.orderform.target='Paypal';document.orderform.submit();">
                                                </span><br>
                        <span class="style4">Quote price is an estimate and does not include shipping or sales tax (for CA residents)</span> </div></td>
              </tr>
              <tr>
                <td colspan="5" class="option_head"><div align="center" class="table_heading"> <a name="options"></a>Options for all journals </div></td>
              </tr>
              <tr class="option_pop">
                <td class="option_pop"><div align="right"></div>
                    <p align="right"><br>
                  </p></td>
                <td colspan="2" class="option_pop"><p align="right">Closing Belt ($14) Yes
                        <input   name="belt" type="radio" class="option_pop" value="14" border="0">
          No
          <input   CHECKED name="belt" type="radio" class="option_pop" value="0" border="0">
          <br>
          <br>
          Special instructions <br>
          <textarea name="instructions" cols="30" rows="5" wrap="VIRTUAL" id="instructions"></textarea>
                  </p>
                    <p align="right">&nbsp; </p></td>
                <td colspan="2" valign="top" class="option_pop"><div align="right">
                    <p>Titling ($9/line) Yes
                        <input   name="title" type="radio" class="option_pop" value="9">
            No
            <input   CHECKED name="title" type="radio" class="option_pop" value="0">
            Lines
            <select name="lines" size="1" id="lines">
              <
              <option value="1" >1</option>
              <option value="2" >2</option>
              <option value="3" >3</option>
              <option value="4" >4</option>
              <option value="5" >5</option>
              <option value="6" >6</option>
              <option value="7" >7</option>
            </select>
                    </p>
                    <p><span class="style2">Use the following option only if you selected 'Titling Yes' above</span> <br>
            Titling style
              <select name="foil" size="1" id="foil">
                <
                <option value="" SELECTED>Select foil color</option>
                <option value="blind" >Blind</option>
                <option value="black" >Black</option>
                <option value="gold" >Gold</option>
                <option value="silver" >Silver</option>
              </select>
              <br>
              <br>
            The cover should read: <br>
            <textarea name="title_text" cols="30" rows="2" wrap="VIRTUAL" id="title_text"></textarea>
            <br>
                    </p>
                </div></td>
              </tr>
              <tr align="right">
                <td colspan="5" nowrap class="table_bottom
	 ">&nbsp;</td>
              </tr>
            </table>
          </form>
          <p>&nbsp;</p>
        </div>

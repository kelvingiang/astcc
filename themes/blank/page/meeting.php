<?php
/*
  Template Name:  meeting page
 */

if (isset($_GET['kid'])) {
    VoteExportToExcel($_GET['kid']);
}
?>
<?php
// lay phan header
get_header();
?>
<style>

</style>
<body id="main_bg">
    <div class=" container-fluid ">
        <div class="row">
            <div class="col-lg-12">
                <!--<label class="vote-title-text">meeting</label>-->
            </div>
            <div class="col-lg-12" style="text-align: right">
                <!--                    <label class="btn btn-large btn-default" onclick="FunctionExportExcel(1)">總會長結果導出</label>
                                    <label class="btn btn-large btn-default" onclick="FunctionExportExcel(2)">監事長結果導出</label>-->
            </div>
            <?php
            $hueizhangList = getVoteResult(1);
            $jianshizhangList = getVoteResult(2);
            ?>
            <div class="col-lg-12">
                <div class="col-lg-12 title-space">會議資訊</div>
                <div class="list_horizontal">
                    <div class="list_col">
                        <div style=" font-weight: bold; color: white;
                             text-align: center; font-size: 20px; padding: 5px; background-color:  #f06801"
                             >
                            <img style= " width: 500px; max-height: 600px"  src="<?php echo WB_URL_IMAGES . 'h3.jpg' ?>" />
                        </div>

                    </div>
                </div>
                <div></div>
            </div>



            <!--//=================================================================-->               
            <?php
            $zangsiList = getVoteResult(3);
//                $zangsi_vote_total = voteTotal(2);
            ?>
            <div class="col-lg-12 title-space" style="margin-top: 70px" ></div>
            <div class="col-lg-12">
                <div class="row new_row">
                    <div class="col-12"><h2>會議日程表（暫定）</h2></div>
                    <div class="col-12">地點：君悅酒店</div>
                    <div class="col-2 right-border">日期</div>
                    <div class="col-2 right-border">時間</div>
                    <div class="col-3 right-border">活動內容</div>
                    <div class="col-3 right-border">地點</div>
                    <div class="col-2">備註</div>

                    <div class="col-2 right-border">12月22日（二）</div>
                    <div class="col-2 right-border">17:00-18:00</div>
                    <div class="col-3 right-border">大會報到(第一階段)</div>
                    <div class="col-3 right-border">晚宴場地：大直典華</br>地址：台北市中山區植福路8號</div>
                    <div class="col-2">全體與會人員報到</div>

                    <div class="col-2 right-border"></div>
                    <div class="col-2 right-border">18:00-21:00</div>
                    <div class="col-3 right-border">交通部歡迎晚宴</div>
                    <div class="col-3 right-border">晚宴場地：大直典華 </br> 地址：台北市中山區植福路8號</div>
                    <div class="col-2">全體與會人員出席</div>

                    <div class="col-2 right-border">12月23日（三）</div>
                    <div class="col-2 right-border">07:30-08:30</div>
                    <div class="col-3 right-border">大會報到(第二階段)</div>
                    <div class="col-3 right-border">三樓凱悅廳君悅酒店</div>
                    <div class="col-2">全體與會人員報到(第一階段未報到人員)</div>

                    <div class="col-2 right-border"></div>
                    <div class="col-2 right-border">08:45-10:15</div>
                    <div class="col-3 right-border">開幕典禮</div>
                    <div class="col-3 right-border">三樓凱悅廳一區君悅酒店</div>
                    <div class="col-2">全體與會人員出席</div>

                    <div class="col-2 right-border"></div>
                    <div class="col-2 right-border">10:15-10:30</div>
                    <div class="col-3 right-border">早茶暨休息時間</div>
                    <div class="col-3 right-border">三樓凱悅廳一區君悅酒店</div>
                    <div class="col-2">與會人員出席</div>

                    <div class="col-2 right-border"></div>
                    <div class="col-2 right-border">10:30-12:30</div>
                    <div class="col-3 right-border">亞洲台商經貿投資論壇(經濟部)</div>
                    <div class="col-3 right-border">三樓凱悅廳二區君悅酒店</div>
                    <div class="col-2">與會人員出席</div> 

                    <div class="col-2 right-border"></div>
                    <div class="col-2 right-border">10:30-12:30</div>
                    <div class="col-3 right-border">亞青第十屆第二次理監事會議</div>
                    <div class="col-3 right-border">三樓鵲迎廳君悅酒店</div>
                    <div class="col-2">亞青理監事以上人員</div>

                    <div class="col-2 right-border"></div>
                    <div class="col-2 right-border">12:30-14:00</div>
                    <div class="col-3 right-border">立法院 外交部 午宴</div>
                    <div class="col-3 right-border">三樓凱悅廳一區君悅酒店</div>
                    <div class="col-2">全體與會人員出席</div>

                    <div class="col-2 right-border"></div>
                    <div class="col-2 right-border">14:00-14:50</div>
                    <div class="col-3 right-border">百工百業商機交流會</div>
                    <div class="col-3 right-border">三樓凱悅廳二區君悅酒店</div>
                    <div class="col-2">全體與會人員出席</div>

                    <div class="col-2 right-border"></div>
                    <div class="col-2 right-border">14:50-15:20</div>
                    <div class="col-3 right-border">午茶暨休息時間</div>
                    <div class="col-3 right-border">三樓凱悅廳二區君悅酒店</div>
                    <div class="col-2">亞總理監事以上人員</div>

                    <div class="col-2 right-border"></div>
                    <div class="col-2 right-border">15:20-17:00</div>
                    <div class="col-3 right-border">第廿八屆第二次理監事聯席會議</div>
                    <div class="col-3 right-border">三樓凱悅廳二區君悅酒店</div>
                    <div class="col-2">全體與會人員出席</div>

                    <div class="col-2 right-border"></div>
                    <div class="col-2 right-border">17:00-17:30</div>
                    <div class="col-3 right-border">第廿八屆第二次理監事聯席會議大合照(閉幕)</div>
                    <div class="col-3 right-border">三樓凱悅廳二區君悅酒店</div>
                    <div class="col-2">亞總理監事以上人員</div>

                    <div class="col-2 right-border"></div>
                    <div class="col-2 right-border">18:30-21:30</div>
                    <div class="col-3 right-border">僑委會晚宴</div>
                    <div class="col-3 right-border">三樓凱悅廳一區君悅酒店</div>
                    <div class="col-2">全體與會人員出席</div>

                </div>
            </div>
            <div class="col-12" style=" height: 10px; background-color:#041595; width: 100%; margin: 50px 20px" ></div>
            <div class="col-lg-12">
                <div class="row new_row">
                    <div class="col-12"><h2>第廿八屆第二次理監事聯席會議</h2></div>
                    <div class="col-6"></div><div class="col-6">【議程】</div>
                    <div class="col-6">日期：2020年12月23日（星期三）</div> <div class="col-6"></div>
                    <div class="col-6">時間：15:20 – 17:30</div> <div class="col-6"></div>
                    <div class="col-6">地點:君悅酒店 三樓凱悅廳二區</div> <div class="col-6"></div>
                    <div class="col-6">主席：總會長 劉樹添</div> <div class="col-6"></div>
                    <div class="col-6">司儀：曾令潔</div> <div class="col-6"></div>
                    <div class="col-6">記錄：秘書處</div> <div class="col-6"></div>
                    <div class="col-6"></div> <div class="col-6"></div>
                    <div class="col-6">一、    秘書處報告本次會議理監事出席人數</div> <div class="col-6"></div>
                    <div class="col-6">二、    主席劉總會長樹添 宣布開會</div> <div class="col-6"></div>
                    <div class="col-6">三、    劉總會長 樹添報告</div> <div class="col-6"></div>
                    <div class="col-6">四、    温秘書長 德農報告</div> <div class="col-6"></div>
                    <div class="col-6">五、    蔡財務長 雯慧報告(視訊)</div> <div class="col-6"></div>
                    <div class="col-6">六、    賴輔導總會長 維信致詞</div> <div class="col-6"></div>
                    <div class="col-6">七、    各國副總會長報告</div> <div class="col-6"></div>
                    <div class=" col-1"></div><div class="col-5">1. 日本台灣商會聯合總會       陳副總會長五福(視訊)</div><div class="col-6">2. 印尼台灣工商聯誼總會       王副總會長勝升</div>
                    <div class=" col-1"></div><div class="col-5">3. 汶萊台灣商會               莊副總會長錫山</div><div class="col-6">4. 柬埔寨台灣商會             王副總會長美蕙</div>
                    <div class=" col-1"></div><div class="col-5">5. 香港台灣工商協會           楊副總會長繼聖</div><div class="col-6">6. 泰國台灣商會聯合總會        郭副總會長修敏</div>
                    <div class=" col-1"></div><div class="col-5">7. 馬來西亞台灣商會聯合總會    林副總會長永昌</div><div class="col-6">8. 菲律賓台商總會              江副總會長福龍</div>
                    <div class=" col-1"></div><div class="col-5">9. 越南台灣商會聯合總會        沈副總會長憲煜</div><div class="col-6">10. 新加坡台北工商協會         楊副總會長正祺</div>
                    <div class=" col-1"></div><div class="col-5">11. 寮國台灣商會聯合總會       楊副總會長鎮奕</div><div class="col-6">12. 緬甸台商總會               何副總會長廷貴</div>
                    <div class=" col-1"></div><div class="col-5">13. 澳門台商聯誼會             簡副總會長廷在</div><div class="col-6">14. 孟加拉台灣商會聯合總會     高副總會長文富</div>
                    <div class=" col-1"></div><div class="col-5">15. 東帝汶台灣商會聯合總會     張副總會長淙涵</div><div class="col-6">16. 關島台灣商會             虞王副總會長利英</div>
                    <div class=" col-1"></div><div class="col-5">17. 印度台灣商會聯合總會       蔡副總會長文欽</div><div class="col-6"></div>
                    <div class="col-6">八、    亞洲青商會長 林會長宇馨報告(視訊)</div> <div class="col-6"></div>
                    <div class="col-6">九、    各功能委員會主委報告(視訊或可以書面報告代之)</div> <div class="col-6"></div>
                    <div class=" col-1"></div><div class="col-5">1.長期發展委員會 賴維信（印）</div><div class="col-6">2.大陸台商聯誼委員會 許世憑（香）</div>
                    <div class=" col-1"></div><div class="col-5">3.財務金融委員會 江文洲（馬）</div><div class="col-6">4.章程委員會 彭春源（印）</div>
                    <div class=" col-1"></div><div class="col-5">5.教育文化委員會 劉美德（越）</div><div class="col-6">6.出版委員會 陳文瑞（泰）</div>
                    <div class=" col-1"></div><div class="col-5">7.公共關係委員會 張坤河（泰）</div><div class="col-6">8. E化事務委員會 邱臣遠 (越) </div>
                    <div class=" col-1"></div><div class="col-5">9.商機委員會 陳家達（越）</div><div class="col-6">10.會務推展委員會 陳潘淼（日）</div>
                    <div class=" col-1"></div><div class="col-5">11. 紀律委員會 林在良（菲）</div><div class="col-6">12.東協經貿委員會 張南蘋 (柬) </div>
                    <div class=" col-1"></div><div class="col-5">13. 危機處理委員會 李天柒 （越）</div><div class="col-6">14.青商輔導委員會 陳五福（日）</div>
                    <div class=" col-1"></div><div class="col-5">15.慈善服務委員會 兪秀霞（日）</div><div class="col-6">16.農漁業推廣委員會 陳信銘（越）</div>
                    <div class=" col-1"></div><div class="col-5">17.專案功能委員會 江福龍（菲）</div><div class="col-6"></div>
                    <div class=" col-1"></div><div class="col-5"></div><div class="col-5"></div>
                    <div class="col-12">十、    賴監事長 昭哲報告</div>
                    <div class="col-12">十一、     提案討論(詳見手冊第  頁~第  頁)</div>
                    <div class="col-12">十二、     臨時動議</div>
                    <div class="col-12">十三、     主席宣布散會</div>
                </div>

            </div>
            <div class="col-12" style=" height: 10px; background-color:#041595; width: 100%; margin: 50px 20px" ></div>

            <div class="col-lg-12" style=" margin-top: 10px">
                <div class="row new_row">
                    <div class="col-12"><h2>僑委會晚宴流程</h2></div>
                    <div class="col-12"  style=" font-weight: bold">時間：109年12月23日（星期三） 18:30---21:30</div>
                    <div class="col-12"  style=" font-weight: bold">地點：台北君悅酒店3樓凱悅廳一區</div>
                    <div class="col-3 right-border" style=" font-weight: bold">時  間</div><div class="col-6 right-border"  style=" font-weight: bold" >內     容</div><div class="col-3 right-border"  style=" font-weight: bold">備    註</div>
                    <div class="col-3 right-border">18:00～18:30</div><div class="col-6 right-border">來賓入座  理監事入座</div><div class="col-3">長官來賓報到處</div>
                    <div class="col-3 right-border">18:00～18:30</div><div class="col-6 right-border">亞總活動影片播放 (當日)</div><div class="col-3"></div>
                    <div class="col-3 right-border">18:30～18:50</div><div class="col-6 right-border">樂團表演</div><div class="col-3"></div>
                    <div class="col-3 right-border">18:50～19:00</div><div class="col-6 right-border">僑委會晚宴開始, 感謝贊助人員,廠商,工作團隊,志工</div><div class="col-3">感謝狀</div>
                    <div class="col-3 right-border">19:10～19:15</div><div class="col-6 right-border">長官致詞, 僑委會 – 童振源委員長 </div><div class="col-3"></div>
                    <div class="col-3 right-border">19:15～19:20</div><div class="col-6 right-border">致 感謝詞, 亞總 劉樹添總會長</div><div class="col-3"></div>
                    <div class="col-3 right-border">19:20～19:35</div><div class="col-6 right-border">貴賓致詞(暫定), 桃園市政府 鄭文燦市長</div><div class="col-3"></div>
                    <div class="col-3 right-border">19:35～19:40</div><div class="col-6 right-border">歌唱冠軍歌手表演</div><div class="col-3"></div>
                    <div class="col-3 right-border">19:40～19:50</div><div class="col-6 right-border">樂團表演</div><div class="col-3"></div>
                    <div class="col-3 right-border">20:00～20:10</div><div class="col-6 right-border">亞總28周年慶生日快樂, 長官貴賓切蛋糕</div><div class="col-3"></div>
                    <div class="col-3 right-border">20:10～21:10</div><div class="col-6 right-border">各會員國才藝歌唱表演</div><div class="col-3"></div>
                    <div class="col-3 right-border">21:10～21:20</div><div class="col-6 right-border">大合唱</div><div class="col-3"></div>
                    <div class="col-3 right-border">21:20～</div><div class="col-6 right-border">晚宴結束 ～ 珍重再見</div><div class="col-3"></div>

                </div>
            </div>


            <div class="col-12" style=" height: 10px; background-color:#041595; width: 100%; margin: 50px 20px" ></div>

            <div class="col-lg-12" style=" margin-top: 10px">
                <div class="row new_row">
                    <div class="col-12"><h2>觀光參訪行程表</h2></div>
                    <div class="col-3 right-border" style=" font-weight: bold">日期</div><div class="col-6 right-border"  style=" font-weight: bold" >行程</div><div class="col-3 right-border"  style=" font-weight: bold">住宿</div>
                    <div class="col-3">Day 1 20 DEC (日)</div><div class="col-6 right-border">08:00-08:30 台北行天宮報到 (松江路農安街口，中山戶政事務所前)</div><div class="col-3"></div>
                    <div class="col-3"></div><div class="col-6 right-border">11:00-12:00 參訪水銡利廚衛生活館</div><div class="col-3">台南富信</div>
                    <div class="col-3"></div><div class="col-6 right-border">12:00-12:50 午餐</div><div class="col-3"></div>
                    <div class="col-3"></div><div class="col-6 right-border">13:30-14:30 參觀國史館台灣文獻館</div><div class="col-3">台南市</div>
                    <div class="col-3"></div><div class="col-6 right-border">15:30-16:30 參訪蘭都蘭花生技園區</div><div class="col-3">成功路 336 號</div>
                    <div class="col-3"></div><div class="col-6 right-border">17:30-18:20 安平老街巡禮</div><div class="col-3">06-2229801</div>
                    <div class="col-3"></div><div class="col-6 right-border">18:30-20:00 晚餐 (赤崁擔仔麵)</div><div class="col-3"></div>
                    <div class="col-3"></div><div class="col-6 right-border">20:00- 前往飯店休息，晚安</div><div class="col-3"></div>
                    <div class="col-12" style="min-height:  2px; background-color:  #041595"></div>
                    <div class="col-3">Day 2 21 DEC (一)</div><div class="col-6 right-border">07:30-09:00 晨喚，早餐</div><div class="col-3"></div>
                    <div class="col-3"></div><div class="col-6 right-border">09:30-12:00 參觀十鼓仁糖文創園區 (水劇場、擊鼓體驗)</div><div class="col-3">桃園諾富特</div>
                    <div class="col-3"></div><div class="col-6 right-border">12:00-13:00 午餐</div><div class="col-3"></div>
                    <div class="col-3"></div><div class="col-6 right-border">15:00-16:30 拜訪巨大捷安特營運總部-中部科學園區</div><div class="col-3">桃園市大園區</div>
                    <div class="col-3"></div><div class="col-6 right-border">16:30-18:00 前往桃園</div><div class="col-3">航站南路 1-1 號</div>
                    <div class="col-3"></div><div class="col-6 right-border">18:30-20:30 晚餐(桃園喜來登 亞洲台商與台灣業者商機交流會)</div><div class="col-3">03-3980222</div>
                    <div class="col-3"></div><div class="col-6 right-border">20:30- 前往飯店休息，晚安</div><div class="col-3"></div>
                    <div class="col-12" style=" min-height: 2px; background-color:  #041595"></div>
                    <div class="col-3">Day 3 22 DEC (二)</div><div class="col-6 right-border">07:30-09:00 晨喚，早餐</div><div class="col-3"></div>
                    <div class="col-3"></div><div class="col-6 right-border">09:30-10:10 參觀凱笙口罩文創工廠</div><div class="col-3"></div>
                    <div class="col-3"></div><div class="col-6 right-border">11:00-12:00 參觀高鐵探索館</div><div class="col-3"></div>
                    <div class="col-3"></div><div class="col-6 right-border">12:00-13:00 午餐</div><div class="col-3"></div>
                    <div class="col-3"></div><div class="col-6 right-border">13:00-14:00 前往會場報到</div><div class="col-3"></div>
                    <div class="col-3"></div><div class="col-6 right-border">14:00-17:00 觀光產業經濟年會</div><div class="col-3"></div>
                    <div class="col-3"></div><div class="col-6 right-border">18:00-20:00 亞洲台商總會歡迎晚宴暨台灣觀光產業交流晚宴</div><div class="col-3"></div>


                </div>
            </div>
            <div class="col-12" style=" height: 10px; background-color:#041595; width: 100%; margin: 50px 20px" ></div>

            <div class="col-lg-12" style=" margin-top: 10px">
                <div class="row new_row">
                    <div class="col-1  right-border">車次</div>
                    <div class="col-2 right-border">導遊</div>
                    <div class="col-2 right-border">電話</div>
                    <div class="col-1 right-border">人數</div>
                    <div class="col-3 right-border">車號</div>
                    <div class="col-3 right-border">司機</div>
                    <div class="col-1 right-border">A</div>
                    <div class="col-2 right-border">蘇俊吉</div>
                    <div class="col-2 right-border">0977-433-688</div>
                    <div class="col-1 right-border">29</div>
                    <div class="col-3 right-border">191-ZZ</div>
                    <div class="col-3 right-border">石永生 0918-060-958</div>
                    <div class="col-1 right-border">B</div>
                    <div class="col-2 right-border">李鳳全</div>
                    <div class="col-2 right-border">0917-765-908</div>
                    <div class="col-1 right-border">30</div>
                    <div class="col-3 right-border">016-WW</div>
                    <div class="col-3 right-border">湯宗霖 0935-522-866</div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .new_row div{
          min-height: 30px;
            line-height: 30px;
            border-bottom: 1px solid  #f2efef;
            font-size: 15px;
                overflow: auto;
                letter-spacing: 1px;
        }

        .new_row h2 {
            color:  #0720dc;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 2px;

        }

        .new_row > .col-5{
            border-right: 1px solid #f2efef;
        }

        .right-border{
            border-right: 1px solid #f2efef;
        }


    </style>
</body>

<script>

    function FunctionExportExcel(id) {
        var url = '<?php echo Chang_Url(); ?>';
        window.location = url + "/vote-result?kid=" + id;
    }
    jQuery(window).on('scroll', function () {
        var scrollTop = jQuery(window).scrollTop(),
                elementOffset = jQuery('#list_title').offset().top,
                listOffset = jQuery('#my_list').offset().top,
                distance = (elementOffset - scrollTop),
                disMyList = (listOffset - scrollTop);
        if (distance <= 0) {
            jQuery('#list_title').addClass('top-style');
            jQuery('#list_title').width(jQuery('#my_list').width());
        }
        if (disMyList >= 30) {
            jQuery('#list_title').removeClass('top-style');
        }
    });
    jQuery(document).ready(function () {
        var hueizhang_agree = <?php echo $hueizhangAgree ?>;
        var hueizhang_anti = <?php echo $hueizhangAnti ?>;
        var jianshi_agree = <?php echo $jianshiAgree ?>;
        var jianshi_anti = <?php echo $jianshiAnti ?>

        jQuery('#hueizhangAgree').html(hueizhang_agree);
        jQuery('#hueizhangAnti').html(hueizhang_anti);
        jQuery('#hueizhangTotal').html(hueizhang_agree + hueizhang_anti);
        jQuery('#jianshiAgree').html(jianshi_agree);
        jQuery('#jianshiAnti').html(jianshi_anti);
        jQuery('#jianshiTotal').html(jianshi_agree + jianshi_anti);

    });
</script>
<?php
// lay phan footer
get_footer();

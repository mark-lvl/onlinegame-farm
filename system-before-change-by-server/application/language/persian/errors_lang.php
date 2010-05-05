<?php
	/*
	    Registration
	*/
	$lang['filling_error']			= "خطای ورود اطلاعات";
	$lang['choose_captcha']         = "بر اساس راهنمایی من, یکی از اشیا را باید انتخاب کنی!<BR />برای این کار روی شکل مورد نظر کلیک کن!";
	$lang['starred_filling']        = "همه ی فیلدهای ستاره دار باید پر شوند!<BR />به نظر می رسد که یک یا چند تا از آن ها را جا انداخته ای!";
	$lang['email_failure1']         = "ایمیلی که وارد کردی حقیقتا ایمیل نیست!<BR />ایمیل به صورت example@example_domain.com یا چیزی شبیه این باید باشد!";
	$lang['email_repeated']         = "این ایمیل قبلا هم در سیستم ثبت شده!<BR />اگر مطمئنی آن را قبلا در این بازی ثبت نکرده ای, از طریق یادآوری رمز, رمز پروفایل را به دست آور و به وسیله ی آن وارد بازی شو!";
	$lang['date_over']				= "تاریخ را اشتباه وارد کردی!";
	$lang['reg_error']              = "با عرض معذرت, انگار خطای نامشخصی در ثبت نام رخ داد!<BR />سعی در حال آن دارم. کمی صبر کن و دوباره تلاش کن.<BR />";
	$lang['captcha_error']          = "شی مورد نظر را اشتباه انتخاب کردی!<BR />دوباره تلاش کن.";
	
	/*
	    Inbox
	*/
	$lang['message_delete']			= "پاک کردن پیام";
	$lang['message_delete_text']	= "مطمئنی که می خواهی این پیام را پاک کنی؟<BR />بعد از تایید امکان بازیابی مجدد پیام وجود ندارد.";
	
	/*
	    Edit profile
	*/
	$lang['password_error']         = "رمزی که وارد کردی با رمز کنونی هماهنگ نبود یا رمز جدید با تکرارش یکی نبود!";


        /*
         *  FARM
         */
        $lang['public']['title'] = "کارت اشتباهه";

        $lang['money']['title'] = "مقدار پول کافی نداری";
        $lang['money']['body'] = "پول مورد نیاز : __PRICE__<br/>دارایی شما :  __MONEY__";
        
        $lang['accessory']['title'] = "برای کاشتن این گیاه باید این لوازمو داشته باشی";
        $lang['accessory']['body'] = "";
        
        $lang['level']['title'] = "level کافی رو نداری";
        $lang['level']['body'] = "برای خرید __ACCESSORY__ باید در مرحله__NEEDLEVEL__ باشی ولی الان مرحله __LEVEL__ هستی";

        $lang['reapConfirm']['title'] = "گزارش مزرعت در این مرحله";
        $lang['reapConfirm']['body'] = "<table><tr><td>            گنجایش مزرعه</td><td>__FARMCAPACITY__ کیلوگرم __TYPENAME__</td></tr><tr><td>            سلامت محصولات</td><td>__HEALTH__ %</td></tr><tr><td>           وزن کل محصولات قابل برداشت</td><td>__AMOUNTPRODUCT__ کیلوگرم</td></tr><tr><td>وزن مورد نیاز یامی در این مرحله</td><td>__MISAMOUNT__ کیلوگرم</td></tr><tr><td>زمان مورد نظر یامی</td><td>__MISDEADLINE__</td></tr><tr><td>زمان درو</td><td>__REAPTIME__</td></tr><tr><td>میزان دریافتی از فروش محصولات</td><td>__TOTALCOST__</td></tr><tr><td>میزان دریافتی ویژه</td><td>__BONUS__</td></tr><tr><td>مرحله شما</td><td>__LEVEL__</td></tr></table>";

        $lang['farmNotNeedSpray']['title'] = "سمپاشی انجام شد";
        $lang['farmNotNeedSpray']['body'] = "<table><tr><td>حشره ی موذی</td><td>__ACCESSORY__</td></tr><tr><td>زمان تاثیر بر روی مزرعه</td><td>__AFFECTTIME__ ثانیه</td></tr><tr><td>میزان کاهش سلامت محصولات</td><td>__DECHEALTH__</td></tr></table>";

        $lang['gunDeffence']['title'] = "با تفنگ فرارشون دادی";
        $lang['gunDeffence']['body'] = "<table><tr><td>مهاجم فراری داده</td><td>__ACCESSORY__</td></tr><tr><td>زمان تاثیر بر روی مزرعه</td><td>__AFFECTTIME__ ثانیه</td></tr><tr><td>میزان کاهش وزن محصولات</td><td>__DECWEIGHT__</td></tr></table>";

        $lang['resource']['title'] = "منابع مورد نیازو نداری";
        $lang['resource']['body'] =  "میزان __RESOURCE__ مورد نیاز __NEED__ <br/>__RESOURCE__ موجود مزرعت __FARMRESOURCE__";
        $lang['error']['plantExists'] = "مزرعت هنوز محصول درو نشده داره";
        $lang['error']['plantDeath'] = "دیگه گیاهات موردن فایده نداره";
        $lang['error']['lackAccessory'] = "دیگه از این تجهیزات نداری";
        $lang['error']['plantResourceExists'] = "گیاهت از این منبع هنوز داره";
        $lang['error']['farmAccessoryExists'] = "مزرعت از این داره";
        $lang['error']['missionExists'] = "الان در حال انجام این ماموریت هستی";
        $lang['error']['notReadyForReap'] = "هنوز زمان درو گیاهات نرسیده";
        $lang['error']['farmNotPlowed'] = "باید اول مزرعتو شخم بزنی";
        $lang['error']['farmPlowedBefore'] = "مزرعت قبلا شخم زده شده";
        $lang['error']['farmNotNeedSpray'] = "الان مزرعت نیازی به سم پاشی نداره";
        $lang['error']['farmNotNeedDeffence'] = "الان نیازی به دفاع از مزرعت نیست";
        $lang['error']['cantAttack'] = "به این مزرعه الان نمیتونی حمله کنی";
        $lang['error']['cantAttackToLevelBelow3'] = "به مزرعه با مرحله ی کمتر از ۳ نمیتونی حمله کنی";
        $lang['error']['cantAttackWithHavntAnti'] = "این مزرعه الان تو مر حله ای نیست که بتونی با این آیتم بهش حمله کنی";
        $lang['error']['cantAttackBeacuseHavntPlant'] = "تو این مزرعه هنوز گیاهی داشته نشده که بخوای اذیتش کنی";
        $lang['error']['cantAttackAttackAlreadyExists'] = "تو الان داری این مزرعرو اذیت میکنی نمیتونی تا قبلی تموم نشده دوباره اینکارو بکنی";
        $lang['error']['cantAttackTwiceInADay'] = "در روز فقط یکبار به این مزرعه میتونی حمله کنی";
        $lang['error']['cantHelpTwiceInADay'] = "در روز فقط یکبار به این مزرعه میتونی کمک کنی";
        $lang['error']['cantResetWhenHavePlant'] = "هنوز تو مزرعت گیاه درو نشده داری فعلا نمیتونی از اول شروع کنی";


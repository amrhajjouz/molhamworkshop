<?php

use App\Models\{Donor, StripeIdealAccount, StripeSepaAccount, StripeSofortAccount, SwishAccount};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


function generateRandomTargetableAmounts ($type, $funded = true) {
    
    $currencies = ['usd', 'eur', 'try', 'cad', 'sar', 'qar', 'aed'];
    $amounts = [];
    
    foreach ($currencies as $c) {
        $amounts['required'][$c] = rand(100, 1000);
        if (!in_array($type, ['sponsorships', 'scholarships'])) {
            $amounts['received'][$c] = ($funded) ? $amounts['required'][$c] : rand(100, $amounts['required'][$c]);
            $amounts['left_to_complete'][$c] = $amounts['required'][$c] = $amounts['received'][$c];
        }
    }
    
    return $amounts;
}


function getRandomArabicWords ($n) {
    
    $dummyArabicTextImploded = explode(' ', 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.
ومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق.
هذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.');
    
    return implode(' ', array_slice($dummyArabicTextImploded, 0, $n));
}

function getRandomWords ($n) {
    
    $dummyTextImploded = explode(' ', "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.");
    
    return implode(' ', array_slice($dummyTextImploded, 0, $n));
}

function generateRandomTargetableContents () {
    
    $contents = [];
    
    foreach (['ar', 'en', 'fr', 'de', 'tr', 'es'] as $l) {
        $contents['title'][$l] = ['auto_generated' => ($l == 'ar' || $l == 'en') ? false : ((rand(0,1)) ? true : false), 'value' => ($l == 'ar') ? getRandomArabicWords(rand(5,12)) : getRandomWords(rand(5,12))];
        $contents['description'][$l] = ['auto_generated' => ($l == 'ar' || $l == 'en') ? false : ((rand(0,1)) ? true : false), 'value' => ($l == 'ar') ? getRandomArabicWords(rand(15,20)) : getRandomWords(rand(15,20))];
        $contents['details'][$l] = ['auto_generated' => ($l == 'ar' || $l == 'en') ? false : ((rand(0,1)) ? true : false), 'value' => ($l == 'ar') ? getRandomArabicWords(rand(30,100)) : getRandomWords(rand(30,100))];
    }
    
    return $contents;
}

function listDummyTargetables($type, $length = 20) {
    
    $faker = Faker\Factory::create();    
    
    $targetables = [];
    
    for ($i = 1; $i <= $length; $i++) {
        
        $funded = $faker->boolean;
        
        $targetable = [
            'id' => $i,
            'contents' => generateRandomTargetableContents(),
            'amounts' => generateRandomTargetableAmounts($type, $funded),
            'liked_by_auth' => (request()->user()) ? $faker->boolean : false,
            'funded_by_auth' => (request()->user()) ? $faker->boolean : false,
            'saved_by_auth' => (request()->user()) ? $faker->boolean : false,
            'likes_count' => $faker->numberBetween($min = 0, $max = 50),
            'comments_count' => $faker->numberBetween($min = 0, $max = 30),
            'shares_count' => $faker->numberBetween($min = 0, $max = 20),
            'published_at' => date('Y-m-d H:i:s' , rand(strtotime('2021-01-01'), time())),
            'preview_images' => null,
        ];
        
        if ($type == 'cases') {
            $targetable['funded'] = $funded;
            $targetable['urgent'] = $faker->boolean;
        }
        
        $targetables[] = $targetable;
    }
    
    return $targetables;
}

function retrieveDummySingleTargetable ($type, $id, $options = []) {
    
    return generateSingleTargetable($type, $id, true);
}

function generateSingleTargetable ($type, $id, $fullDetails = false, $options = []) {
    
    $faker = \Faker\Factory::create();    
    
    $targetable = [];
    
    $funded = ($id % 3 == 0) ? true : false;
    
    $targetable = [
        'id' => $id,
        'contents' => generateRandomTargetableContents(),
        'amounts' => generateRandomTargetableAmounts($type, $funded),
        'liked_by_auth' => (request()->user()) ? $faker->boolean : false,
        'funded_by_auth' => (request()->user()) ? $faker->boolean : false,
        'saved_by_auth' => (request()->user()) ? $faker->boolean : false,
        'likes_count' => $faker->numberBetween($min = 0, $max = 50),
        'comments_count' => $faker->numberBetween($min = 0, $max = 30),
        'shares_count' => $faker->numberBetween($min = 0, $max = 20),
        'published_at' => date('Y-m-d H:i:s' , rand(strtotime('2021-01-01'), time())),
        'preview_images' => null,
    ];
    
    if ($type == 'cases') {
        $targetable['funded'] = $funded;
        $targetable['urgent'] = ($id % 5 == 0) ? true : false;
    } else if ($type == 'campaigns') {
        $targetable['funded'] = $funded;
        $targetable['urgent'] = $faker->boolean;
    } else if ($type == 'sponsorships') {
        $targetable['sponsored'] = $faker->boolean;
    } else if ($type == 'scholarships') {
        $targetable['funded'] = $funded;
        $targetable['sponsored'] = $faker->boolean;
    } else if ($type == 'small_projects') {
        $targetable['funded'] = $funded;
    } else if ($type == 'events') {
        
    } else if ($type == 'projects') {
        $targetable['funded'] = $funded;
    } else if ($type == 'fundraisers') {
        
    }    
    
    return $targetable;
}
<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TempCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = array(
            array('code' => 'AF','en_name' => 'Afghanistan','ar_name' => 'أفغانستان','en_nationality' => 'Afghan','ar_nationality' => 'أفغانستاني'),
            array('code' => 'AL','en_name' => 'Albania','ar_name' => 'ألبانيا','en_nationality' => 'Albanian','ar_nationality' => 'ألباني'),
            array('code' => 'AX','en_name' => 'Aland Islands','ar_name' => 'جزر آلاند','en_nationality' => 'Aland Islander','ar_nationality' => 'آلاندي'),
            array('code' => 'DZ','en_name' => 'Algeria','ar_name' => 'الجزائر','en_nationality' => 'Algerian','ar_nationality' => 'جزائري'),
            array('code' => 'AS','en_name' => 'American Samoa','ar_name' => 'ساموا-الأمريكي','en_nationality' => 'American Samoan','ar_nationality' => 'أمريكي سامواني'),
            array('code' => 'AD','en_name' => 'Andorra','ar_name' => 'أندورا','en_nationality' => 'Andorran','ar_nationality' => 'أندوري'),
            array('code' => 'AO','en_name' => 'Angola','ar_name' => 'أنغولا','en_nationality' => 'Angolan','ar_nationality' => 'أنقولي'),
            array('code' => 'AI','en_name' => 'Anguilla','ar_name' => 'أنغويلا','en_nationality' => 'Anguillan','ar_nationality' => 'أنغويلي'),
            array('code' => 'AQ','en_name' => 'Antarctica','ar_name' => 'أنتاركتيكا','en_nationality' => 'Antarctican','ar_nationality' => 'أنتاركتيكي'),
            array('code' => 'AG','en_name' => 'Antigua and Barbuda','ar_name' => 'أنتيغوا وبربودا','en_nationality' => 'Antiguan','ar_nationality' => 'بربودي'),
            array('code' => 'AR','en_name' => 'Argentina','ar_name' => 'الأرجنتين','en_nationality' => 'Argentinian','ar_nationality' => 'أرجنتيني'),
            array('code' => 'AM','en_name' => 'Armenia','ar_name' => 'أرمينيا','en_nationality' => 'Armenian','ar_nationality' => 'أرميني'),
            array('code' => 'AW','en_name' => 'Aruba','ar_name' => 'أروبه','en_nationality' => 'Aruban','ar_nationality' => 'أوروبهيني'),
            array('code' => 'AU','en_name' => 'Australia','ar_name' => 'أستراليا','en_nationality' => 'Australian','ar_nationality' => 'أسترالي'),
            array('code' => 'AT','en_name' => 'Austria','ar_name' => 'النمسا','en_nationality' => 'Austrian','ar_nationality' => 'نمساوي'),
            array('code' => 'AZ','en_name' => 'Azerbaijan','ar_name' => 'أذربيجان','en_nationality' => 'Azerbaijani','ar_nationality' => 'أذربيجاني'),
            array('code' => 'BS','en_name' => 'Bahamas','ar_name' => 'الباهاماس','en_nationality' => 'Bahamian','ar_nationality' => 'باهاميسي'),
            array('code' => 'BH','en_name' => 'Bahrain','ar_name' => 'البحرين','en_nationality' => 'Bahraini','ar_nationality' => 'بحريني'),
            array('code' => 'BD','en_name' => 'Bangladesh','ar_name' => 'بنغلاديش','en_nationality' => 'Bangladeshi','ar_nationality' => 'بنغلاديشي'),
            array('code' => 'BB','en_name' => 'Barbados','ar_name' => 'بربادوس','en_nationality' => 'Barbadian','ar_nationality' => 'بربادوسي'),
            array('code' => 'BY','en_name' => 'Belarus','ar_name' => 'روسيا البيضاء','en_nationality' => 'Belarusian','ar_nationality' => 'روسي'),
            array('code' => 'BE','en_name' => 'Belgium','ar_name' => 'بلجيكا','en_nationality' => 'Belgian','ar_nationality' => 'بلجيكي'),
            array('code' => 'BZ','en_name' => 'Belize','ar_name' => 'بيليز','en_nationality' => 'Belizean','ar_nationality' => 'بيليزي'),
            array('code' => 'BJ','en_name' => 'Benin','ar_name' => 'بنين','en_nationality' => 'Beninese','ar_nationality' => 'بنيني'),
            array('code' => 'BL','en_name' => 'Saint Barthelemy','ar_name' => 'سان بارتيلمي','en_nationality' => 'Saint Barthelmian','ar_nationality' => 'سان بارتيلمي'),
            array('code' => 'BM','en_name' => 'Bermuda','ar_name' => 'جزر برمودا','en_nationality' => 'Bermudan','ar_nationality' => 'برمودي'),
            array('code' => 'BT','en_name' => 'Bhutan','ar_name' => 'بوتان','en_nationality' => 'Bhutanese','ar_nationality' => 'بوتاني'),
            array('code' => 'BO','en_name' => 'Bolivia','ar_name' => 'بوليفيا','en_nationality' => 'Bolivian','ar_nationality' => 'بوليفي'),
            array('code' => 'BA','en_name' => 'Bosnia and Herzegovina','ar_name' => 'البوسنة و الهرسك','en_nationality' => 'Bosnian / Herzegovinian','ar_nationality' => 'بوسني/هرسكي'),
            array('code' => 'BW','en_name' => 'Botswana','ar_name' => 'بوتسوانا','en_nationality' => 'Botswanan','ar_nationality' => 'بوتسواني'),
            array('code' => 'BV','en_name' => 'Bouvet Island','ar_name' => 'جزيرة بوفيه','en_nationality' => 'Bouvetian','ar_nationality' => 'بوفيهي'),
            array('code' => 'BR','en_name' => 'Brazil','ar_name' => 'البرازيل','en_nationality' => 'Brazilian','ar_nationality' => 'برازيلي'),
            array('code' => 'IO','en_name' => 'British Indian Ocean Territory','ar_name' => 'إقليم المحيط الهندي البريطاني','en_nationality' => 'British Indian Ocean Territory','ar_nationality' => 'إقليم المحيط الهندي البريطاني'),
            array('code' => 'BN','en_name' => 'Brunei Darussalam','ar_name' => 'بروني','en_nationality' => 'Bruneian','ar_nationality' => 'بروني'),
            array('code' => 'BG','en_name' => 'Bulgaria','ar_name' => 'بلغاريا','en_nationality' => 'Bulgarian','ar_nationality' => 'بلغاري'),
            array('code' => 'BF','en_name' => 'Burkina Faso','ar_name' => 'بوركينا فاسو','en_nationality' => 'Burkinabe','ar_nationality' => 'بوركيني'),
            array('code' => 'BI','en_name' => 'Burundi','ar_name' => 'بوروندي','en_nationality' => 'Burundian','ar_nationality' => 'بورونيدي'),
            array('code' => 'KH','en_name' => 'Cambodia','ar_name' => 'كمبوديا','en_nationality' => 'Cambodian','ar_nationality' => 'كمبودي'),
            array('code' => 'CM','en_name' => 'Cameroon','ar_name' => 'كاميرون','en_nationality' => 'Cameroonian','ar_nationality' => 'كاميروني'),
            array('code' => 'CA','en_name' => 'Canada','ar_name' => 'كندا','en_nationality' => 'Canadian','ar_nationality' => 'كندي'),
            array('code' => 'CV','en_name' => 'Cape Verde','ar_name' => 'الرأس الأخضر','en_nationality' => 'Cape Verdean','ar_nationality' => 'الرأس الأخضر'),
            array('code' => 'KY','en_name' => 'Cayman Islands','ar_name' => 'جزر كايمان','en_nationality' => 'Caymanian','ar_nationality' => 'كايماني'),
            array('code' => 'CF','en_name' => 'Central African Republic','ar_name' => 'جمهورية أفريقيا الوسطى','en_nationality' => 'Central African','ar_nationality' => 'أفريقي'),
            array('code' => 'TD','en_name' => 'Chad','ar_name' => 'تشاد','en_nationality' => 'Chadian','ar_nationality' => 'تشادي'),
            array('code' => 'CL','en_name' => 'Chile','ar_name' => 'شيلي','en_nationality' => 'Chilean','ar_nationality' => 'شيلي'),
            array('code' => 'CN','en_name' => 'China','ar_name' => 'الصين','en_nationality' => 'Chinese','ar_nationality' => 'صيني'),
            array('code' => 'CX','en_name' => 'Christmas Island','ar_name' => 'جزيرة عيد الميلاد','en_nationality' => 'Christmas Islander','ar_nationality' => 'جزيرة عيد الميلاد'),
            array('code' => 'CC','en_name' => 'Cocos (Keeling) Islands','ar_name' => 'جزر كوكوس','en_nationality' => 'Cocos Islander','ar_nationality' => 'جزر كوكوس'),
            array('code' => 'CO','en_name' => 'Colombia','ar_name' => 'كولومبيا','en_nationality' => 'Colombian','ar_nationality' => 'كولومبي'),
            array('code' => 'KM','en_name' => 'Comoros','ar_name' => 'جزر القمر','en_nationality' => 'Comorian','ar_nationality' => 'جزر القمر'),
            array('code' => 'CG','en_name' => 'Congo','ar_name' => 'الكونغو','en_nationality' => 'Congolese','ar_nationality' => 'كونغي'),
            array('code' => 'CK','en_name' => 'Cook Islands','ar_name' => 'جزر كوك','en_nationality' => 'Cook Islander','ar_nationality' => 'جزر كوك'),
            array('code' => 'CR','en_name' => 'Costa Rica','ar_name' => 'كوستاريكا','en_nationality' => 'Costa Rican','ar_nationality' => 'كوستاريكي'),
            array('code' => 'HR','en_name' => 'Croatia','ar_name' => 'كرواتيا','en_nationality' => 'Croatian','ar_nationality' => 'كوراتي'),
            array('code' => 'CU','en_name' => 'Cuba','ar_name' => 'كوبا','en_nationality' => 'Cuban','ar_nationality' => 'كوبي'),
            array('code' => 'CY','en_name' => 'Cyprus','ar_name' => 'قبرص','en_nationality' => 'Cypriot','ar_nationality' => 'قبرصي'),
            array('code' => 'CW','en_name' => 'Curaçao','ar_name' => 'كوراساو','en_nationality' => 'Curacian','ar_nationality' => 'كوراساوي'),
            array('code' => 'CZ','en_name' => 'Czech Republic','ar_name' => 'الجمهورية التشيكية','en_nationality' => 'Czech','ar_nationality' => 'تشيكي'),
            array('code' => 'DK','en_name' => 'Denmark','ar_name' => 'الدانمارك','en_nationality' => 'Danish','ar_nationality' => 'دنماركي'),
            array('code' => 'DJ','en_name' => 'Djibouti','ar_name' => 'جيبوتي','en_nationality' => 'Djiboutian','ar_nationality' => 'جيبوتي'),
            array('code' => 'DM','en_name' => 'Dominica','ar_name' => 'دومينيكا','en_nationality' => 'Dominican','ar_nationality' => 'دومينيكي'),
            array('code' => 'DO','en_name' => 'Dominican Republic','ar_name' => 'الجمهورية الدومينيكية','en_nationality' => 'Dominican','ar_nationality' => 'دومينيكي'),
            array('code' => 'EC','en_name' => 'Ecuador','ar_name' => 'إكوادور','en_nationality' => 'Ecuadorian','ar_nationality' => 'إكوادوري'),
            array('code' => 'EG','en_name' => 'Egypt','ar_name' => 'مصر','en_nationality' => 'Egyptian','ar_nationality' => 'مصري'),
            array('code' => 'SV','en_name' => 'El Salvador','ar_name' => 'إلسلفادور','en_nationality' => 'Salvadoran','ar_nationality' => 'سلفادوري'),
            array('code' => 'GQ','en_name' => 'Equatorial Guinea','ar_name' => 'غينيا الاستوائي','en_nationality' => 'Equatorial Guinean','ar_nationality' => 'غيني'),
            array('code' => 'ER','en_name' => 'Eritrea','ar_name' => 'إريتريا','en_nationality' => 'Eritrean','ar_nationality' => 'إريتيري'),
            array('code' => 'EE','en_name' => 'Estonia','ar_name' => 'استونيا','en_nationality' => 'Estonian','ar_nationality' => 'استوني'),
            array('code' => 'ET','en_name' => 'Ethiopia','ar_name' => 'أثيوبيا','en_nationality' => 'Ethiopian','ar_nationality' => 'أثيوبي'),
            array('code' => 'FK','en_name' => 'Falkland Islands (Malvinas)','ar_name' => 'جزر فوكلاند','en_nationality' => 'Falkland Islander','ar_nationality' => 'فوكلاندي'),
            array('code' => 'FO','en_name' => 'Faroe Islands','ar_name' => 'جزر فارو','en_nationality' => 'Faroese','ar_nationality' => 'جزر فارو'),
            array('code' => 'FJ','en_name' => 'Fiji','ar_name' => 'فيجي','en_nationality' => 'Fijian','ar_nationality' => 'فيجي'),
            array('code' => 'FI','en_name' => 'Finland','ar_name' => 'فنلندا','en_nationality' => 'Finnish','ar_nationality' => 'فنلندي'),
            array('code' => 'FR','en_name' => 'France','ar_name' => 'فرنسا','en_nationality' => 'French','ar_nationality' => 'فرنسي'),
            array('code' => 'GF','en_name' => 'French Guiana','ar_name' => 'غويانا الفرنسية','en_nationality' => 'French Guianese','ar_nationality' => 'غويانا الفرنسية'),
            array('code' => 'PF','en_name' => 'French Polynesia','ar_name' => 'بولينيزيا الفرنسية','en_nationality' => 'French Polynesian','ar_nationality' => 'بولينيزيي'),
            array('code' => 'TF','en_name' => 'French Southern and Antarctic Lands','ar_name' => 'أراض فرنسية جنوبية وأنتارتيكية','en_nationality' => 'French','ar_nationality' => 'أراض فرنسية جنوبية وأنتارتيكية'),
            array('code' => 'GA','en_name' => 'Gabon','ar_name' => 'الغابون','en_nationality' => 'Gabonese','ar_nationality' => 'غابوني'),
            array('code' => 'GM','en_name' => 'Gambia','ar_name' => 'غامبيا','en_nationality' => 'Gambian','ar_nationality' => 'غامبي'),
            array('code' => 'GE','en_name' => 'Georgia','ar_name' => 'جيورجيا','en_nationality' => 'Georgian','ar_nationality' => 'جيورجي'),
            array('code' => 'DE','en_name' => 'Germany','ar_name' => 'ألمانيا','en_nationality' => 'German','ar_nationality' => 'ألماني'),
            array('code' => 'GH','en_name' => 'Ghana','ar_name' => 'غانا','en_nationality' => 'Ghanaian','ar_nationality' => 'غاني'),
            array('code' => 'GI','en_name' => 'Gibraltar','ar_name' => 'جبل طارق','en_nationality' => 'Gibraltar','ar_nationality' => 'جبل طارق'),
            array('code' => 'GG','en_name' => 'Guernsey','ar_name' => 'غيرنزي','en_nationality' => 'Guernsian','ar_nationality' => 'غيرنزي'),
            array('code' => 'GR','en_name' => 'Greece','ar_name' => 'اليونان','en_nationality' => 'Greek','ar_nationality' => 'يوناني'),
            array('code' => 'GL','en_name' => 'Greenland','ar_name' => 'جرينلاند','en_nationality' => 'Greenlandic','ar_nationality' => 'جرينلاندي'),
            array('code' => 'GD','en_name' => 'Grenada','ar_name' => 'غرينادا','en_nationality' => 'Grenadian','ar_nationality' => 'غرينادي'),
            array('code' => 'GP','en_name' => 'Guadeloupe','ar_name' => 'جزر جوادلوب','en_nationality' => 'Guadeloupe','ar_nationality' => 'جزر جوادلوب'),
            array('code' => 'GU','en_name' => 'Guam','ar_name' => 'جوام','en_nationality' => 'Guamanian','ar_nationality' => 'جوامي'),
            array('code' => 'GT','en_name' => 'Guatemala','ar_name' => 'غواتيمال','en_nationality' => 'Guatemalan','ar_nationality' => 'غواتيمالي'),
            array('code' => 'GN','en_name' => 'Guinea','ar_name' => 'غينيا','en_nationality' => 'Guinean','ar_nationality' => 'غيني'),
            array('code' => 'GW','en_name' => 'Guinea-Bissau','ar_name' => 'غينيا-بيساو','en_nationality' => 'Guinea-Bissauan','ar_nationality' => 'غيني'),
            array('code' => 'GY','en_name' => 'Guyana','ar_name' => 'غيانا','en_nationality' => 'Guyanese','ar_nationality' => 'غياني'),
            array('code' => 'HT','en_name' => 'Haiti','ar_name' => 'هايتي','en_nationality' => 'Haitian','ar_nationality' => 'هايتي'),
            array('code' => 'HM','en_name' => 'Heard and Mc Donald Islands','ar_name' => 'جزيرة هيرد وجزر ماكدونالد','en_nationality' => 'Heard and Mc Donald Islanders','ar_nationality' => 'جزيرة هيرد وجزر ماكدونالد'),
            array('code' => 'HN','en_name' => 'Honduras','ar_name' => 'هندوراس','en_nationality' => 'Honduran','ar_nationality' => 'هندوراسي'),
            array('code' => 'HK','en_name' => 'Hong Kong','ar_name' => 'هونغ كونغ','en_nationality' => 'Hongkongese','ar_nationality' => 'هونغ كونغي'),
            array('code' => 'HU','en_name' => 'Hungary','ar_name' => 'المجر','en_nationality' => 'Hungarian','ar_nationality' => 'مجري'),
            array('code' => 'IS','en_name' => 'Iceland','ar_name' => 'آيسلندا','en_nationality' => 'Icelandic','ar_nationality' => 'آيسلندي'),
            array('code' => 'IN','en_name' => 'India','ar_name' => 'الهند','en_nationality' => 'Indian','ar_nationality' => 'هندي'),
            array('code' => 'IM','en_name' => 'Isle of Man','ar_name' => 'جزيرة مان','en_nationality' => 'Manx','ar_nationality' => 'ماني'),
            array('code' => 'ID','en_name' => 'Indonesia','ar_name' => 'أندونيسيا','en_nationality' => 'Indonesian','ar_nationality' => 'أندونيسيي'),
            array('code' => 'IR','en_name' => 'Iran','ar_name' => 'إيران','en_nationality' => 'Iranian','ar_nationality' => 'إيراني'),
            array('code' => 'IQ','en_name' => 'Iraq','ar_name' => 'العراق','en_nationality' => 'Iraqi','ar_nationality' => 'عراقي'),
            array('code' => 'IE','en_name' => 'Ireland','ar_name' => 'إيرلندا','en_nationality' => 'Irish','ar_nationality' => 'إيرلندي'),
            array('code' => 'IL','en_name' => 'Israel','ar_name' => 'إسرائيل','en_nationality' => 'Israeli','ar_nationality' => 'إسرائيلي'),
            array('code' => 'IT','en_name' => 'Italy','ar_name' => 'إيطاليا','en_nationality' => 'Italian','ar_nationality' => 'إيطالي'),
            array('code' => 'CI','en_name' => 'Ivory Coast','ar_name' => 'ساحل العاج','en_nationality' => 'Ivory Coastian','ar_nationality' => 'ساحل العاج'),
            array('code' => 'JE','en_name' => 'Jersey','ar_name' => 'جيرزي','en_nationality' => 'Jersian','ar_nationality' => 'جيرزي'),
            array('code' => 'JM','en_name' => 'Jamaica','ar_name' => 'جمايكا','en_nationality' => 'Jamaican','ar_nationality' => 'جمايكي'),
            array('code' => 'JP','en_name' => 'Japan','ar_name' => 'اليابان','en_nationality' => 'Japanese','ar_nationality' => 'ياباني'),
            array('code' => 'JO','en_name' => 'Jordan','ar_name' => 'الأردن','en_nationality' => 'Jordanian','ar_nationality' => 'أردني'),
            array('code' => 'KZ','en_name' => 'Kazakhstan','ar_name' => 'كازاخستان','en_nationality' => 'Kazakh','ar_nationality' => 'كازاخستاني'),
            array('code' => 'KE','en_name' => 'Kenya','ar_name' => 'كينيا','en_nationality' => 'Kenyan','ar_nationality' => 'كيني'),
            array('code' => 'KI','en_name' => 'Kiribati','ar_name' => 'كيريباتي','en_nationality' => 'I-Kiribati','ar_nationality' => 'كيريباتي'),
            array('code' => 'KP','en_name' => 'Korea(North Korea)','ar_name' => 'كوريا الشمالية','en_nationality' => 'North Korean','ar_nationality' => 'كوري'),
            array('code' => 'KR','en_name' => 'Korea(South Korea)','ar_name' => 'كوريا الجنوبية','en_nationality' => 'South Korean','ar_nationality' => 'كوري'),
            array('code' => 'XK','en_name' => 'Kosovo','ar_name' => 'كوسوفو','en_nationality' => 'Kosovar','ar_nationality' => 'كوسيفي'),
            array('code' => 'KW','en_name' => 'Kuwait','ar_name' => 'الكويت','en_nationality' => 'Kuwaiti','ar_nationality' => 'كويتي'),
            array('code' => 'KG','en_name' => 'Kyrgyzstan','ar_name' => 'قيرغيزستان','en_nationality' => 'Kyrgyzstani','ar_nationality' => 'قيرغيزستاني'),
            array('code' => 'LA','en_name' => 'Lao PDR','ar_name' => 'لاوس','en_nationality' => 'Laotian','ar_nationality' => 'لاوسي'),
            array('code' => 'LV','en_name' => 'Latvia','ar_name' => 'لاتفيا','en_nationality' => 'Latvian','ar_nationality' => 'لاتيفي'),
            array('code' => 'LB','en_name' => 'Lebanon','ar_name' => 'لبنان','en_nationality' => 'Lebanese','ar_nationality' => 'لبناني'),
            array('code' => 'LS','en_name' => 'Lesotho','ar_name' => 'ليسوتو','en_nationality' => 'Basotho','ar_nationality' => 'ليوسيتي'),
            array('code' => 'LR','en_name' => 'Liberia','ar_name' => 'ليبيريا','en_nationality' => 'Liberian','ar_nationality' => 'ليبيري'),
            array('code' => 'LY','en_name' => 'Libya','ar_name' => 'ليبيا','en_nationality' => 'Libyan','ar_nationality' => 'ليبي'),
            array('code' => 'LI','en_name' => 'Liechtenstein','ar_name' => 'ليختنشتين','en_nationality' => 'Liechtenstein','ar_nationality' => 'ليختنشتيني'),
            array('code' => 'LT','en_name' => 'Lithuania','ar_name' => 'لتوانيا','en_nationality' => 'Lithuanian','ar_nationality' => 'لتوانيي'),
            array('code' => 'LU','en_name' => 'Luxembourg','ar_name' => 'لوكسمبورغ','en_nationality' => 'Luxembourger','ar_nationality' => 'لوكسمبورغي'),
            array('code' => 'LK','en_name' => 'Sri Lanka','ar_name' => 'سريلانكا','en_nationality' => 'Sri Lankian','ar_nationality' => 'سريلانكي'),
            array('code' => 'MO','en_name' => 'Macau','ar_name' => 'ماكاو','en_nationality' => 'Macanese','ar_nationality' => 'ماكاوي'),
            array('code' => 'MK','en_name' => 'Macedonia','ar_name' => 'مقدونيا','en_nationality' => 'Macedonian','ar_nationality' => 'مقدوني'),
            array('code' => 'MG','en_name' => 'Madagascar','ar_name' => 'مدغشقر','en_nationality' => 'Malagasy','ar_nationality' => 'مدغشقري'),
            array('code' => 'MW','en_name' => 'Malawi','ar_name' => 'مالاوي','en_nationality' => 'Malawian','ar_nationality' => 'مالاوي'),
            array('code' => 'MY','en_name' => 'Malaysia','ar_name' => 'ماليزيا','en_nationality' => 'Malaysian','ar_nationality' => 'ماليزي'),
            array('code' => 'MV','en_name' => 'Maldives','ar_name' => 'المالديف','en_nationality' => 'Maldivian','ar_nationality' => 'مالديفي'),
            array('code' => 'ML','en_name' => 'Mali','ar_name' => 'مالي','en_nationality' => 'Malian','ar_nationality' => 'مالي'),
            array('code' => 'MT','en_name' => 'Malta','ar_name' => 'مالطا','en_nationality' => 'Maltese','ar_nationality' => 'مالطي'),
            array('code' => 'MH','en_name' => 'Marshall Islands','ar_name' => 'جزر مارشال','en_nationality' => 'Marshallese','ar_nationality' => 'مارشالي'),
            array('code' => 'MQ','en_name' => 'Martinique','ar_name' => 'مارتينيك','en_nationality' => 'Martiniquais','ar_nationality' => 'مارتينيكي'),
            array('code' => 'MR','en_name' => 'Mauritania','ar_name' => 'موريتانيا','en_nationality' => 'Mauritanian','ar_nationality' => 'موريتانيي'),
            array('code' => 'MU','en_name' => 'Mauritius','ar_name' => 'موريشيوس','en_nationality' => 'Mauritian','ar_nationality' => 'موريشيوسي'),
            array('code' => 'YT','en_name' => 'Mayotte','ar_name' => 'مايوت','en_nationality' => 'Mahoran','ar_nationality' => 'مايوتي'),
            array('code' => 'MX','en_name' => 'Mexico','ar_name' => 'المكسيك','en_nationality' => 'Mexican','ar_nationality' => 'مكسيكي'),
            array('code' => 'FM','en_name' => 'Micronesia','ar_name' => 'مايكرونيزيا','en_nationality' => 'Micronesian','ar_nationality' => 'مايكرونيزيي'),
            array('code' => 'MD','en_name' => 'Moldova','ar_name' => 'مولدافيا','en_nationality' => 'Moldovan','ar_nationality' => 'مولديفي'),
            array('code' => 'MC','en_name' => 'Monaco','ar_name' => 'موناكو','en_nationality' => 'Monacan','ar_nationality' => 'مونيكي'),
            array('code' => 'MN','en_name' => 'Mongolia','ar_name' => 'منغوليا','en_nationality' => 'Mongolian','ar_nationality' => 'منغولي'),
            array('code' => 'ME','en_name' => 'Montenegro','ar_name' => 'الجبل الأسود','en_nationality' => 'Montenegrin','ar_nationality' => 'الجبل الأسود'),
            array('code' => 'MS','en_name' => 'Montserrat','ar_name' => 'مونتسيرات','en_nationality' => 'Montserratian','ar_nationality' => 'مونتسيراتي'),
            array('code' => 'MA','en_name' => 'Morocco','ar_name' => 'المغرب','en_nationality' => 'Moroccan','ar_nationality' => 'مغربي'),
            array('code' => 'MZ','en_name' => 'Mozambique','ar_name' => 'موزمبيق','en_nationality' => 'Mozambican','ar_nationality' => 'موزمبيقي'),
            array('code' => 'MM','en_name' => 'Myanmar','ar_name' => 'ميانمار','en_nationality' => 'Myanmarian','ar_nationality' => 'ميانماري'),
            array('code' => 'NA','en_name' => 'Namibia','ar_name' => 'ناميبيا','en_nationality' => 'Namibian','ar_nationality' => 'ناميبي'),
            array('code' => 'NR','en_name' => 'Nauru','ar_name' => 'نورو','en_nationality' => 'Nauruan','ar_nationality' => 'نوري'),
            array('code' => 'NP','en_name' => 'Nepal','ar_name' => 'نيبال','en_nationality' => 'Nepalese','ar_nationality' => 'نيبالي'),
            array('code' => 'NL','en_name' => 'Netherlands','ar_name' => 'هولندا','en_nationality' => 'Dutch','ar_nationality' => 'هولندي'),
            array('code' => 'AN','en_name' => 'Netherlands Antilles','ar_name' => 'جزر الأنتيل الهولندي','en_nationality' => 'Dutch Antilier','ar_nationality' => 'هولندي'),
            array('code' => 'NC','en_name' => 'New Caledonia','ar_name' => 'كاليدونيا الجديدة','en_nationality' => 'New Caledonian','ar_nationality' => 'كاليدوني'),
            array('code' => 'NZ','en_name' => 'New Zealand','ar_name' => 'نيوزيلندا','en_nationality' => 'New Zealander','ar_nationality' => 'نيوزيلندي'),
            array('code' => 'NI','en_name' => 'Nicaragua','ar_name' => 'نيكاراجوا','en_nationality' => 'Nicaraguan','ar_nationality' => 'نيكاراجوي'),
            array('code' => 'NE','en_name' => 'Niger','ar_name' => 'النيجر','en_nationality' => 'Nigerien','ar_nationality' => 'نيجيري'),
            array('code' => 'NG','en_name' => 'Nigeria','ar_name' => 'نيجيريا','en_nationality' => 'Nigerian','ar_nationality' => 'نيجيري'),
            array('code' => 'NU','en_name' => 'Niue','ar_name' => 'ني','en_nationality' => 'Niuean','ar_nationality' => 'ني'),
            array('code' => 'NF','en_name' => 'Norfolk Island','ar_name' => 'جزيرة نورفولك','en_nationality' => 'Norfolk Islander','ar_nationality' => 'نورفوليكي'),
            array('code' => 'MP','en_name' => 'Northern Mariana Islands','ar_name' => 'جزر ماريانا الشمالية','en_nationality' => 'Northern Marianan','ar_nationality' => 'ماريني'),
            array('code' => 'NO','en_name' => 'Norway','ar_name' => 'النرويج','en_nationality' => 'Norwegian','ar_nationality' => 'نرويجي'),
            array('code' => 'OM','en_name' => 'Oman','ar_name' => 'عمان','en_nationality' => 'Omani','ar_nationality' => 'عماني'),
            array('code' => 'PK','en_name' => 'Pakistan','ar_name' => 'باكستان','en_nationality' => 'Pakistani','ar_nationality' => 'باكستاني'),
            array('code' => 'PW','en_name' => 'Palau','ar_name' => 'بالاو','en_nationality' => 'Palauan','ar_nationality' => 'بالاوي'),
            array('code' => 'PS','en_name' => 'Palestine','ar_name' => 'فلسطين','en_nationality' => 'Palestinian','ar_nationality' => 'فلسطيني'),
            array('code' => 'PA','en_name' => 'Panama','ar_name' => 'بنما','en_nationality' => 'Panamanian','ar_nationality' => 'بنمي'),
            array('code' => 'PG','en_name' => 'Papua New Guinea','ar_name' => 'بابوا غينيا الجديدة','en_nationality' => 'Papua New Guinean','ar_nationality' => 'بابوي'),
            array('code' => 'PY','en_name' => 'Paraguay','ar_name' => 'باراغواي','en_nationality' => 'Paraguayan','ar_nationality' => 'بارغاوي'),
            array('code' => 'PE','en_name' => 'Peru','ar_name' => 'بيرو','en_nationality' => 'Peruvian','ar_nationality' => 'بيري'),
            array('code' => 'PH','en_name' => 'Philippines','ar_name' => 'الفليبين','en_nationality' => 'Filipino','ar_nationality' => 'فلبيني'),
            array('code' => 'PN','en_name' => 'Pitcairn','ar_name' => 'بيتكيرن','en_nationality' => 'Pitcairn Islander','ar_nationality' => 'بيتكيرني'),
            array('code' => 'PL','en_name' => 'Poland','ar_name' => 'بولونيا','en_nationality' => 'Polish','ar_nationality' => 'بوليني'),
            array('code' => 'PT','en_name' => 'Portugal','ar_name' => 'البرتغال','en_nationality' => 'Portuguese','ar_nationality' => 'برتغالي'),
            array('code' => 'PR','en_name' => 'Puerto Rico','ar_name' => 'بورتو ريكو','en_nationality' => 'Puerto Rican','ar_nationality' => 'بورتي'),
            array('code' => 'QA','en_name' => 'Qatar','ar_name' => 'قطر','en_nationality' => 'Qatari','ar_nationality' => 'قطري'),
            array('code' => 'RE','en_name' => 'Reunion Island','ar_name' => 'ريونيون','en_nationality' => 'Reunionese','ar_nationality' => 'ريونيوني'),
            array('code' => 'RO','en_name' => 'Romania','ar_name' => 'رومانيا','en_nationality' => 'Romanian','ar_nationality' => 'روماني'),
            array('code' => 'RU','en_name' => 'Russian','ar_name' => 'روسيا','en_nationality' => 'Russian','ar_nationality' => 'روسي'),
            array('code' => 'RW','en_name' => 'Rwanda','ar_name' => 'رواندا','en_nationality' => 'Rwandan','ar_nationality' => 'رواندا'),
            array('code' => 'KN','en_name' => 'Saint Kitts and Nevis','ar_name' => 'سانت كيتس ونيفس,','en_nationality' => 'Kittitian/Nevisian','ar_nationality' => 'سانت كيتس ونيفس'),
            array('code' => 'MF','en_name' => 'Saint Martin (French part)','ar_name' => 'ساينت مارتن فرنسي','en_nationality' => 'St. Martian(French)','ar_nationality' => 'ساينت مارتني فرنسي'),
            array('code' => 'SX','en_name' => 'Sint Maarten (Dutch part)','ar_name' => 'ساينت مارتن هولندي','en_nationality' => 'St. Martian(Dutch)','ar_nationality' => 'ساينت مارتني هولندي'),
            array('code' => 'LC','en_name' => 'Saint Pierre and Miquelon','ar_name' => 'سان بيير وميكلون','en_nationality' => 'St. Pierre and Miquelon','ar_nationality' => 'سان بيير وميكلوني'),
            array('code' => 'VC','en_name' => 'Saint Vincent and the Grenadines','ar_name' => 'سانت فنسنت وجزر غرينادين','en_nationality' => 'Saint Vincent and the Grenadines','ar_nationality' => 'سانت فنسنت وجزر غرينادين'),
            array('code' => 'WS','en_name' => 'Samoa','ar_name' => 'ساموا','en_nationality' => 'Samoan','ar_nationality' => 'ساموي'),
            array('code' => 'SM','en_name' => 'San Marino','ar_name' => 'سان مارينو','en_nationality' => 'Sammarinese','ar_nationality' => 'ماريني'),
            array('code' => 'ST','en_name' => 'Sao Tome and Principe','ar_name' => 'ساو تومي وبرينسيبي','en_nationality' => 'Sao Tomean','ar_nationality' => 'ساو تومي وبرينسيبي'),
            array('code' => 'SA','en_name' => 'Saudi Arabia','ar_name' => 'المملكة العربية السعودية','en_nationality' => 'Saudi Arabian','ar_nationality' => 'سعودي'),
            array('code' => 'SN','en_name' => 'Senegal','ar_name' => 'السنغال','en_nationality' => 'Senegalese','ar_nationality' => 'سنغالي'),
            array('code' => 'RS','en_name' => 'Serbia','ar_name' => 'صربيا','en_nationality' => 'Serbian','ar_nationality' => 'صربي'),
            array('code' => 'SC','en_name' => 'Seychelles','ar_name' => 'سيشيل','en_nationality' => 'Seychellois','ar_nationality' => 'سيشيلي'),
            array('code' => 'SL','en_name' => 'Sierra Leone','ar_name' => 'سيراليون','en_nationality' => 'Sierra Leonean','ar_nationality' => 'سيراليوني'),
            array('code' => 'SG','en_name' => 'Singapore','ar_name' => 'سنغافورة','en_nationality' => 'Singaporean','ar_nationality' => 'سنغافوري'),
            array('code' => 'SK','en_name' => 'Slovakia','ar_name' => 'سلوفاكيا','en_nationality' => 'Slovak','ar_nationality' => 'سولفاكي'),
            array('code' => 'SI','en_name' => 'Slovenia','ar_name' => 'سلوفينيا','en_nationality' => 'Slovenian','ar_nationality' => 'سولفيني'),
            array('code' => 'SB','en_name' => 'Solomon Islands','ar_name' => 'جزر سليمان','en_nationality' => 'Solomon Island','ar_nationality' => 'جزر سليمان'),
            array('code' => 'SO','en_name' => 'Somalia','ar_name' => 'الصومال','en_nationality' => 'Somali','ar_nationality' => 'صومالي'),
            array('code' => 'ZA','en_name' => 'South Africa','ar_name' => 'جنوب أفريقيا','en_nationality' => 'South African','ar_nationality' => 'أفريقي'),
            array('code' => 'GS','en_name' => 'South Georgia and the South Sandwich','ar_name' => 'المنطقة القطبية الجنوبية','en_nationality' => 'South Georgia and the South Sandwich','ar_nationality' => 'لمنطقة القطبية الجنوبية'),
            array('code' => 'SS','en_name' => 'South Sudan','ar_name' => 'السودان الجنوبي','en_nationality' => 'South Sudanese','ar_nationality' => 'سوادني جنوبي'),
            array('code' => 'ES','en_name' => 'Spain','ar_name' => 'إسبانيا','en_nationality' => 'Spanish','ar_nationality' => 'إسباني'),
            array('code' => 'SH','en_name' => 'Saint Helena','ar_name' => 'سانت هيلانة','en_nationality' => 'St. Helenian','ar_nationality' => 'هيلاني'),
            array('code' => 'SD','en_name' => 'Sudan','ar_name' => 'السودان','en_nationality' => 'Sudanese','ar_nationality' => 'سوداني'),
            array('code' => 'SR','en_name' => 'Suriname','ar_name' => 'سورينام','en_nationality' => 'Surinamese','ar_nationality' => 'سورينامي'),
            array('code' => 'SJ','en_name' => 'Svalbard and Jan Mayen','ar_name' => 'سفالبارد ويان ماين','en_nationality' => 'Svalbardian/Jan Mayenian','ar_nationality' => 'سفالبارد ويان ماين'),
            array('code' => 'SZ','en_name' => 'Swaziland','ar_name' => 'سوازيلند','en_nationality' => 'Swazi','ar_nationality' => 'سوازيلندي'),
            array('code' => 'SE','en_name' => 'Sweden','ar_name' => 'السويد','en_nationality' => 'Swedish','ar_nationality' => 'سويدي'),
            array('code' => 'CH','en_name' => 'Switzerland','ar_name' => 'سويسرا','en_nationality' => 'Swiss','ar_nationality' => 'سويسري'),
            array('code' => 'SY','en_name' => 'Syria','ar_name' => 'سوريا','en_nationality' => 'Syrian','ar_nationality' => 'سوري'),
            array('code' => 'TW','en_name' => 'Taiwan','ar_name' => 'تايوان','en_nationality' => 'Taiwanese','ar_nationality' => 'تايواني'),
            array('code' => 'TJ','en_name' => 'Tajikistan','ar_name' => 'طاجيكستان','en_nationality' => 'Tajikistani','ar_nationality' => 'طاجيكستاني'),
            array('code' => 'TZ','en_name' => 'Tanzania','ar_name' => 'تنزانيا','en_nationality' => 'Tanzanian','ar_nationality' => 'تنزانيي'),
            array('code' => 'TH','en_name' => 'Thailand','ar_name' => 'تايلندا','en_nationality' => 'Thai','ar_nationality' => 'تايلندي'),
            array('code' => 'TL','en_name' => 'Timor-Leste','ar_name' => 'تيمور الشرقية','en_nationality' => 'Timor-Lestian','ar_nationality' => 'تيموري'),
            array('code' => 'TG','en_name' => 'Togo','ar_name' => 'توغو','en_nationality' => 'Togolese','ar_nationality' => 'توغي'),
            array('code' => 'TK','en_name' => 'Tokelau','ar_name' => 'توكيلاو','en_nationality' => 'Tokelaian','ar_nationality' => 'توكيلاوي'),
            array('code' => 'TO','en_name' => 'Tonga','ar_name' => 'تونغا','en_nationality' => 'Tongan','ar_nationality' => 'تونغي'),
            array('code' => 'TT','en_name' => 'Trinidad and Tobago','ar_name' => 'ترينيداد وتوباغو','en_nationality' => 'Trinidadian/Tobagonian','ar_nationality' => 'ترينيداد وتوباغو'),
            array('code' => 'TN','en_name' => 'Tunisia','ar_name' => 'تونس','en_nationality' => 'Tunisian','ar_nationality' => 'تونسي'),
            array('code' => 'TR','en_name' => 'Turkey','ar_name' => 'تركيا','en_nationality' => 'Turkish','ar_nationality' => 'تركي'),
            array('code' => 'TM','en_name' => 'Turkmenistan','ar_name' => 'تركمانستان','en_nationality' => 'Turkmen','ar_nationality' => 'تركمانستاني'),
            array('code' => 'TC','en_name' => 'Turks and Caicos Islands','ar_name' => 'جزر توركس وكايكوس','en_nationality' => 'Turks and Caicos Islands','ar_nationality' => 'جزر توركس وكايكوس'),
            array('code' => 'TV','en_name' => 'Tuvalu','ar_name' => 'توفالو','en_nationality' => 'Tuvaluan','ar_nationality' => 'توفالي'),
            array('code' => 'UG','en_name' => 'Uganda','ar_name' => 'أوغندا','en_nationality' => 'Ugandan','ar_nationality' => 'أوغندي'),
            array('code' => 'UA','en_name' => 'Ukraine','ar_name' => 'أوكرانيا','en_nationality' => 'Ukrainian','ar_nationality' => 'أوكراني'),
            array('code' => 'AE','en_name' => 'United Arab Emirates','ar_name' => 'الإمارات العربية المتحدة','en_nationality' => 'Emirati','ar_nationality' => 'إماراتي'),
            array('code' => 'GB','en_name' => 'United Kingdom','ar_name' => 'المملكة المتحدة','en_nationality' => 'British','ar_nationality' => 'بريطاني'),
            array('code' => 'US','en_name' => 'United States','ar_name' => 'الولايات المتحدة','en_nationality' => 'American','ar_nationality' => 'أمريكي'),
            array('code' => 'UM','en_name' => 'US Minor Outlying Islands','ar_name' => 'قائمة الولايات والمناطق الأمريكية','en_nationality' => 'US Minor Outlying Islander','ar_nationality' => 'أمريكي'),
            array('code' => 'UY','en_name' => 'Uruguay','ar_name' => 'أورغواي','en_nationality' => 'Uruguayan','ar_nationality' => 'أورغواي'),
            array('code' => 'UZ','en_name' => 'Uzbekistan','ar_name' => 'أوزباكستان','en_nationality' => 'Uzbek','ar_nationality' => 'أوزباكستاني'),
            array('code' => 'VU','en_name' => 'Vanuatu','ar_name' => 'فانواتو','en_nationality' => 'Vanuatuan','ar_nationality' => 'فانواتي'),
            array('code' => 'VE','en_name' => 'Venezuela','ar_name' => 'فنزويلا','en_nationality' => 'Venezuelan','ar_nationality' => 'فنزويلي'),
            array('code' => 'VN','en_name' => 'Vietnam','ar_name' => 'فيتنام','en_nationality' => 'Vietnamese','ar_nationality' => 'فيتنامي'),
            array('code' => 'VI','en_name' => 'Virgin Islands (U.S.)','ar_name' => 'الجزر العذراء الأمريكي','en_nationality' => 'American Virgin Islander','ar_nationality' => 'أمريكي'),
            array('code' => 'VA','en_name' => 'Vatican City','ar_name' => 'فنزويلا','en_nationality' => 'Vatican','ar_nationality' => 'فاتيكاني'),
            array('code' => 'WF','en_name' => 'Wallis and Futuna Islands','ar_name' => 'والس وفوتونا','en_nationality' => 'Wallisian/Futunan','ar_nationality' => 'فوتوني'),
            array('code' => 'EH','en_name' => 'Western Sahara','ar_name' => 'الصحراء الغربية','en_nationality' => 'Sahrawian','ar_nationality' => 'صحراوي'),
            array('code' => 'YE','en_name' => 'Yemen','ar_name' => 'اليمن','en_nationality' => 'Yemeni','ar_nationality' => 'يمني'),
            array('code' => 'ZM','en_name' => 'Zambia','ar_name' => 'زامبيا','en_nationality' => 'Zambian','ar_nationality' => 'زامبياني'),
            array('code' => 'ZW','en_name' => 'Zimbabwe','ar_name' => 'زمبابوي','en_nationality' => 'Zimbabwean','ar_nationality' => 'زمبابوي')
          );

$codes = collect(array(
	'AD'=>array('name'=>'ANDORRA','code'=>'376'),
	'AE'=>array('name'=>'UNITED ARAB EMIRATES','code'=>'971'),
	'AF'=>array('name'=>'AFGHANISTAN','code'=>'93'),
	'AG'=>array('name'=>'ANTIGUA AND BARBUDA','code'=>'1268'),
	'AI'=>array('name'=>'ANGUILLA','code'=>'1264'),
	'AL'=>array('name'=>'ALBANIA','code'=>'355'),
	'AM'=>array('name'=>'ARMENIA','code'=>'374'),
	'AN'=>array('name'=>'NETHERLANDS ANTILLES','code'=>'599'),
	'AO'=>array('name'=>'ANGOLA','code'=>'244'),
	'AQ'=>array('name'=>'ANTARCTICA','code'=>'672'),
	'AR'=>array('name'=>'ARGENTINA','code'=>'54'),
	'AS'=>array('name'=>'AMERICAN SAMOA','code'=>'1684'),
	'AT'=>array('name'=>'AUSTRIA','code'=>'43'),
	'AU'=>array('name'=>'AUSTRALIA','code'=>'61'),
	'AW'=>array('name'=>'ARUBA','code'=>'297'),
	'AZ'=>array('name'=>'AZERBAIJAN','code'=>'994'),
	'BA'=>array('name'=>'BOSNIA AND HERZEGOVINA','code'=>'387'),
	'BB'=>array('name'=>'BARBADOS','code'=>'1246'),
	'BD'=>array('name'=>'BANGLADESH','code'=>'880'),
	'BE'=>array('name'=>'BELGIUM','code'=>'32'),
	'BF'=>array('name'=>'BURKINA FASO','code'=>'226'),
	'BG'=>array('name'=>'BULGARIA','code'=>'359'),
	'BH'=>array('name'=>'BAHRAIN','code'=>'973'),
	'BI'=>array('name'=>'BURUNDI','code'=>'257'),
	'BJ'=>array('name'=>'BENIN','code'=>'229'),
	'BL'=>array('name'=>'SAINT BARTHELEMY','code'=>'590'),
	'BM'=>array('name'=>'BERMUDA','code'=>'1441'),
	'BN'=>array('name'=>'BRUNEI DARUSSALAM','code'=>'673'),
	'BO'=>array('name'=>'BOLIVIA','code'=>'591'),
	'BR'=>array('name'=>'BRAZIL','code'=>'55'),
	'BS'=>array('name'=>'BAHAMAS','code'=>'1242'),
	'BT'=>array('name'=>'BHUTAN','code'=>'975'),
	'BW'=>array('name'=>'BOTSWANA','code'=>'267'),
	'BY'=>array('name'=>'BELARUS','code'=>'375'),
	'BZ'=>array('name'=>'BELIZE','code'=>'501'),
	'CA'=>array('name'=>'CANADA','code'=>'1'),
	'CC'=>array('name'=>'COCOS (KEELING) ISLANDS','code'=>'61'),
	'CD'=>array('name'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE','code'=>'243'),
	'CF'=>array('name'=>'CENTRAL AFRICAN REPUBLIC','code'=>'236'),
	'CG'=>array('name'=>'CONGO','code'=>'242'),
	'CH'=>array('name'=>'SWITZERLAND','code'=>'41'),
	'CI'=>array('name'=>'COTE D IVOIRE','code'=>'225'),
	'CK'=>array('name'=>'COOK ISLANDS','code'=>'682'),
	'CL'=>array('name'=>'CHILE','code'=>'56'),
	'CM'=>array('name'=>'CAMEROON','code'=>'237'),
	'CN'=>array('name'=>'CHINA','code'=>'86'),
	'CO'=>array('name'=>'COLOMBIA','code'=>'57'),
	'CR'=>array('name'=>'COSTA RICA','code'=>'506'),
	'CU'=>array('name'=>'CUBA','code'=>'53'),
	'CV'=>array('name'=>'CAPE VERDE','code'=>'238'),
	'CX'=>array('name'=>'CHRISTMAS ISLAND','code'=>'61'),
	'CY'=>array('name'=>'CYPRUS','code'=>'357'),
	'CZ'=>array('name'=>'CZECH REPUBLIC','code'=>'420'),
	'DE'=>array('name'=>'GERMANY','code'=>'49'),
	'DJ'=>array('name'=>'DJIBOUTI','code'=>'253'),
	'DK'=>array('name'=>'DENMARK','code'=>'45'),
	'DM'=>array('name'=>'DOMINICA','code'=>'1767'),
	'DO'=>array('name'=>'DOMINICAN REPUBLIC','code'=>'1809'),
	'DZ'=>array('name'=>'ALGERIA','code'=>'213'),
	'EC'=>array('name'=>'ECUADOR','code'=>'593'),
	'EE'=>array('name'=>'ESTONIA','code'=>'372'),
	'EG'=>array('name'=>'EGYPT','code'=>'20'),
	'ER'=>array('name'=>'ERITREA','code'=>'291'),
	'ES'=>array('name'=>'SPAIN','code'=>'34'),
	'ET'=>array('name'=>'ETHIOPIA','code'=>'251'),
	'FI'=>array('name'=>'FINLAND','code'=>'358'),
	'FJ'=>array('name'=>'FIJI','code'=>'679'),
	'FK'=>array('name'=>'FALKLAND ISLANDS (MALVINAS)','code'=>'500'),
	'FM'=>array('name'=>'MICRONESIA, FEDERATED STATES OF','code'=>'691'),
	'FO'=>array('name'=>'FAROE ISLANDS','code'=>'298'),
	'FR'=>array('name'=>'FRANCE','code'=>'33'),
	'GA'=>array('name'=>'GABON','code'=>'241'),
	'GB'=>array('name'=>'UNITED KINGDOM','code'=>'44'),
	'GD'=>array('name'=>'GRENADA','code'=>'1473'),
	'GE'=>array('name'=>'GEORGIA','code'=>'995'),
	'GH'=>array('name'=>'GHANA','code'=>'233'),
	'GI'=>array('name'=>'GIBRALTAR','code'=>'350'),
	'GL'=>array('name'=>'GREENLAND','code'=>'299'),
	'GM'=>array('name'=>'GAMBIA','code'=>'220'),
	'GN'=>array('name'=>'GUINEA','code'=>'224'),
	'GQ'=>array('name'=>'EQUATORIAL GUINEA','code'=>'240'),
	'GR'=>array('name'=>'GREECE','code'=>'30'),
	'GT'=>array('name'=>'GUATEMALA','code'=>'502'),
	'GU'=>array('name'=>'GUAM','code'=>'1671'),
	'GW'=>array('name'=>'GUINEA-BISSAU','code'=>'245'),
	'GY'=>array('name'=>'GUYANA','code'=>'592'),
	'HK'=>array('name'=>'HONG KONG','code'=>'852'),
	'HN'=>array('name'=>'HONDURAS','code'=>'504'),
	'HR'=>array('name'=>'CROATIA','code'=>'385'),
	'HT'=>array('name'=>'HAITI','code'=>'509'),
	'HU'=>array('name'=>'HUNGARY','code'=>'36'),
	'ID'=>array('name'=>'INDONESIA','code'=>'62'),
	'IE'=>array('name'=>'IRELAND','code'=>'353'),
	'IL'=>array('name'=>'ISRAEL','code'=>'972'),
	'IM'=>array('name'=>'ISLE OF MAN','code'=>'44'),
	'IN'=>array('name'=>'INDIA','code'=>'91'),
	'IQ'=>array('name'=>'IRAQ','code'=>'964'),
	'IR'=>array('name'=>'IRAN, ISLAMIC REPUBLIC OF','code'=>'98'),
	'IS'=>array('name'=>'ICELAND','code'=>'354'),
	'IT'=>array('name'=>'ITALY','code'=>'39'),
	'JM'=>array('name'=>'JAMAICA','code'=>'1876'),
	'JO'=>array('name'=>'JORDAN','code'=>'962'),
	'JP'=>array('name'=>'JAPAN','code'=>'81'),
	'KE'=>array('name'=>'KENYA','code'=>'254'),
	'KG'=>array('name'=>'KYRGYZSTAN','code'=>'996'),
	'KH'=>array('name'=>'CAMBODIA','code'=>'855'),
	'KI'=>array('name'=>'KIRIBATI','code'=>'686'),
	'KM'=>array('name'=>'COMOROS','code'=>'269'),
	'KN'=>array('name'=>'SAINT KITTS AND NEVIS','code'=>'1869'),
	'KP'=>array('name'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF','code'=>'850'),
	'KR'=>array('name'=>'KOREA REPUBLIC OF','code'=>'82'),
	'KW'=>array('name'=>'KUWAIT','code'=>'965'),
	'KY'=>array('name'=>'CAYMAN ISLANDS','code'=>'1345'),
	'KZ'=>array('name'=>'KAZAKSTAN','code'=>'7'),
	'LA'=>array('name'=>'LAO PEOPLES DEMOCRATIC REPUBLIC','code'=>'856'),
	'LB'=>array('name'=>'LEBANON','code'=>'961'),
	'LC'=>array('name'=>'SAINT LUCIA','code'=>'1758'),
	'LI'=>array('name'=>'LIECHTENSTEIN','code'=>'423'),
	'LK'=>array('name'=>'SRI LANKA','code'=>'94'),
	'LR'=>array('name'=>'LIBERIA','code'=>'231'),
	'LS'=>array('name'=>'LESOTHO','code'=>'266'),
	'LT'=>array('name'=>'LITHUANIA','code'=>'370'),
	'LU'=>array('name'=>'LUXEMBOURG','code'=>'352'),
	'LV'=>array('name'=>'LATVIA','code'=>'371'),
	'LY'=>array('name'=>'LIBYAN ARAB JAMAHIRIYA','code'=>'218'),
	'MA'=>array('name'=>'MOROCCO','code'=>'212'),
	'MC'=>array('name'=>'MONACO','code'=>'377'),
	'MD'=>array('name'=>'MOLDOVA, REPUBLIC OF','code'=>'373'),
	'ME'=>array('name'=>'MONTENEGRO','code'=>'382'),
	'MF'=>array('name'=>'SAINT MARTIN','code'=>'1599'),
	'MG'=>array('name'=>'MADAGASCAR','code'=>'261'),
	'MH'=>array('name'=>'MARSHALL ISLANDS','code'=>'692'),
	'MK'=>array('name'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','code'=>'389'),
	'ML'=>array('name'=>'MALI','code'=>'223'),
	'MM'=>array('name'=>'MYANMAR','code'=>'95'),
	'MN'=>array('name'=>'MONGOLIA','code'=>'976'),
	'MO'=>array('name'=>'MACAU','code'=>'853'),
	'MP'=>array('name'=>'NORTHERN MARIANA ISLANDS','code'=>'1670'),
	'MR'=>array('name'=>'MAURITANIA','code'=>'222'),
	'MS'=>array('name'=>'MONTSERRAT','code'=>'1664'),
	'MT'=>array('name'=>'MALTA','code'=>'356'),
	'MU'=>array('name'=>'MAURITIUS','code'=>'230'),
	'MV'=>array('name'=>'MALDIVES','code'=>'960'),
	'MW'=>array('name'=>'MALAWI','code'=>'265'),
	'MX'=>array('name'=>'MEXICO','code'=>'52'),
	'MY'=>array('name'=>'MALAYSIA','code'=>'60'),
	'MZ'=>array('name'=>'MOZAMBIQUE','code'=>'258'),
	'NA'=>array('name'=>'NAMIBIA','code'=>'264'),
	'NC'=>array('name'=>'NEW CALEDONIA','code'=>'687'),
	'NE'=>array('name'=>'NIGER','code'=>'227'),
	'NG'=>array('name'=>'NIGERIA','code'=>'234'),
	'NI'=>array('name'=>'NICARAGUA','code'=>'505'),
	'NL'=>array('name'=>'NETHERLANDS','code'=>'31'),
	'NO'=>array('name'=>'NORWAY','code'=>'47'),
	'NP'=>array('name'=>'NEPAL','code'=>'977'),
	'NR'=>array('name'=>'NAURU','code'=>'674'),
	'NU'=>array('name'=>'NIUE','code'=>'683'),
	'NZ'=>array('name'=>'NEW ZEALAND','code'=>'64'),
	'OM'=>array('name'=>'OMAN','code'=>'968'),
	'PA'=>array('name'=>'PANAMA','code'=>'507'),
	'PE'=>array('name'=>'PERU','code'=>'51'),
	'PF'=>array('name'=>'FRENCH POLYNESIA','code'=>'689'),
	'PG'=>array('name'=>'PAPUA NEW GUINEA','code'=>'675'),
	'PH'=>array('name'=>'PHILIPPINES','code'=>'63'),
	'PK'=>array('name'=>'PAKISTAN','code'=>'92'),
	'PL'=>array('name'=>'POLAND','code'=>'48'),
	'PM'=>array('name'=>'SAINT PIERRE AND MIQUELON','code'=>'508'),
	'PN'=>array('name'=>'PITCAIRN','code'=>'870'),
	'PR'=>array('name'=>'PUERTO RICO','code'=>'1'),
	'PT'=>array('name'=>'PORTUGAL','code'=>'351'),
	'PW'=>array('name'=>'PALAU','code'=>'680'),
	'PY'=>array('name'=>'PARAGUAY','code'=>'595'),
	'QA'=>array('name'=>'QATAR','code'=>'974'),
	'RO'=>array('name'=>'ROMANIA','code'=>'40'),
	'RS'=>array('name'=>'SERBIA','code'=>'381'),
	'RU'=>array('name'=>'RUSSIAN FEDERATION','code'=>'7'),
	'RW'=>array('name'=>'RWANDA','code'=>'250'),
	'SA'=>array('name'=>'SAUDI ARABIA','code'=>'966'),
	'SB'=>array('name'=>'SOLOMON ISLANDS','code'=>'677'),
	'SC'=>array('name'=>'SEYCHELLES','code'=>'248'),
	'SD'=>array('name'=>'SUDAN','code'=>'249'),
	'SE'=>array('name'=>'SWEDEN','code'=>'46'),
	'SG'=>array('name'=>'SINGAPORE','code'=>'65'),
	'SH'=>array('name'=>'SAINT HELENA','code'=>'290'),
	'SI'=>array('name'=>'SLOVENIA','code'=>'386'),
	'SK'=>array('name'=>'SLOVAKIA','code'=>'421'),
	'SL'=>array('name'=>'SIERRA LEONE','code'=>'232'),
	'SM'=>array('name'=>'SAN MARINO','code'=>'378'),
	'SN'=>array('name'=>'SENEGAL','code'=>'221'),
	'SO'=>array('name'=>'SOMALIA','code'=>'252'),
	'SR'=>array('name'=>'SURINAME','code'=>'597'),
	'ST'=>array('name'=>'SAO TOME AND PRINCIPE','code'=>'239'),
	'SV'=>array('name'=>'EL SALVADOR','code'=>'503'),
	'SY'=>array('name'=>'SYRIAN ARAB REPUBLIC','code'=>'963'),
	'SZ'=>array('name'=>'SWAZILAND','code'=>'268'),
	'TC'=>array('name'=>'TURKS AND CAICOS ISLANDS','code'=>'1649'),
	'TD'=>array('name'=>'CHAD','code'=>'235'),
	'TG'=>array('name'=>'TOGO','code'=>'228'),
	'TH'=>array('name'=>'THAILAND','code'=>'66'),
	'TJ'=>array('name'=>'TAJIKISTAN','code'=>'992'),
	'TK'=>array('name'=>'TOKELAU','code'=>'690'),
	'TL'=>array('name'=>'TIMOR-LESTE','code'=>'670'),
	'TM'=>array('name'=>'TURKMENISTAN','code'=>'993'),
	'TN'=>array('name'=>'TUNISIA','code'=>'216'),
	'TO'=>array('name'=>'TONGA','code'=>'676'),
	'TR'=>array('name'=>'TURKEY','code'=>'90'),
	'TT'=>array('name'=>'TRINIDAD AND TOBAGO','code'=>'1868'),
	'TV'=>array('name'=>'TUVALU','code'=>'688'),
	'TW'=>array('name'=>'TAIWAN, PROVINCE OF CHINA','code'=>'886'),
	'TZ'=>array('name'=>'TANZANIA, UNITED REPUBLIC OF','code'=>'255'),
	'UA'=>array('name'=>'UKRAINE','code'=>'380'),
	'UG'=>array('name'=>'UGANDA','code'=>'256'),
	'US'=>array('name'=>'UNITED STATES','code'=>'1'),
	'UY'=>array('name'=>'URUGUAY','code'=>'598'),
	'UZ'=>array('name'=>'UZBEKISTAN','code'=>'998'),
	'VA'=>array('name'=>'HOLY SEE (VATICAN CITY STATE)','code'=>'39'),
	'VC'=>array('name'=>'SAINT VINCENT AND THE GRENADINES','code'=>'1784'),
	'VE'=>array('name'=>'VENEZUELA','code'=>'58'),
	'VG'=>array('name'=>'VIRGIN ISLANDS, BRITISH','code'=>'1284'),
	'VI'=>array('name'=>'VIRGIN ISLANDS, U.S.','code'=>'1340'),
	'VN'=>array('name'=>'VIET NAM','code'=>'84'),
	'VU'=>array('name'=>'VANUATU','code'=>'678'),
	'WF'=>array('name'=>'WALLIS AND FUTUNA','code'=>'681'),
	'WS'=>array('name'=>'SAMOA','code'=>'685'),
	'XK'=>array('name'=>'KOSOVO','code'=>'381'),
	'YE'=>array('name'=>'YEMEN','code'=>'967'),
	'YT'=>array('name'=>'MAYOTTE','code'=>'262'),
	'ZA'=>array('name'=>'SOUTH AFRICA','code'=>'27'),
	'ZM'=>array('name'=>'ZAMBIA','code'=>'260'),
	'ZW'=>array('name'=>'ZIMBABWE','code'=>'263')
));


foreach ($countries as $country) {
    $code = " ";
    foreach ($codes as $key => $value) {
        // dd($key );
        if($key == $country['code']){
            $code = $value['code'];
        }
    }
   
    Country::create([
        'code' => $country['code'] , 
        'name' => [
            'ar' => $country['ar_name']  ,
            'en' => $country['en_name']  ,
        ] ,
        'nationality' => [
            'ar' => $country['ar_nationality']  ,
            'en' => $country['en_nationality']  ,
        ] ,
        'dial_code' => "+" .$code
        ]);
    // dd($country , $codes);

}
// dd(1);
        // $countries2 = json_decode(
        //     {
        //     "name": "Afghanistan",
        //     "dial_code": "+93",
        //     "code": "AF"
        //     },
        //     {
        //     "name": "Aland Islands",
        //     "dial_code": "+358",
        //     "code": "AX"
        //     },
        //     {
        //     "name": "Albania",
        //     "dial_code": "+355",
        //     "code": "AL"
        //     },
        //     {
        //     "name": "Algeria",
        //     "dial_code": "+213",
        //     "code": "DZ"
        //     },
        //     {
        //     "name": "AmericanSamoa",
        //     "dial_code": "+1684",
        //     "code": "AS"
        //     },
        //     {
        //     "name": "Andorra",
        //     "dial_code": "+376",
        //     "code": "AD"
        //     },
        //     {
        //     "name": "Angola",
        //     "dial_code": "+244",
        //     "code": "AO"
        //     },
        //     {
        //     "name": "Anguilla",
        //     "dial_code": "+1264",
        //     "code": "AI"
        //     },
        //     {
        //     "name": "Antarctica",
        //     "dial_code": "+672",
        //     "code": "AQ"
        //     },
        //     {
        //     "name": "Antigua and Barbuda",
        //     "dial_code": "+1268",
        //     "code": "AG"
        //     },
        //     {
        //     "name": "Argentina",
        //     "dial_code": "+54",
        //     "code": "AR"
        //     },
        //     {
        //     "name": "Armenia",
        //     "dial_code": "+374",
        //     "code": "AM"
        //     },
        //     {
        //     "name": "Aruba",
        //     "dial_code": "+297",
        //     "code": "AW"
        //     },
        //     {
        //     "name": "Australia",
        //     "dial_code": "+61",
        //     "code": "AU"
        //     },
        //     {
        //     "name": "Austria",
        //     "dial_code": "+43",
        //     "code": "AT"
        //     },
        //     {
        //     "name": "Azerbaijan",
        //     "dial_code": "+994",
        //     "code": "AZ"
        //     },
        //     {
        //     "name": "Bahamas",
        //     "dial_code": "+1242",
        //     "code": "BS"
        //     },
        //     {
        //     "name": "Bahrain",
        //     "dial_code": "+973",
        //     "code": "BH"
        //     },
        //     {
        //     "name": "Bangladesh",
        //     "dial_code": "+880",
        //     "code": "BD"
        //     },
        //     {
        //     "name": "Barbados",
        //     "dial_code": "+1246",
        //     "code": "BB"
        //     },
        //     {
        //     "name": "Belarus",
        //     "dial_code": "+375",
        //     "code": "BY"
        //     },
        //     {
        //     "name": "Belgium",
        //     "dial_code": "+32",
        //     "code": "BE"
        //     },
        //     {
        //     "name": "Belize",
        //     "dial_code": "+501",
        //     "code": "BZ"
        //     },
        //     {
        //     "name": "Benin",
        //     "dial_code": "+229",
        //     "code": "BJ"
        //     },
        //     {
        //     "name": "Bermuda",
        //     "dial_code": "+1441",
        //     "code": "BM"
        //     },
        //     {
        //     "name": "Bhutan",
        //     "dial_code": "+975",
        //     "code": "BT"
        //     },
        //     {
        //     "name": "Bolivia, Plurinational State of",
        //     "dial_code": "+591",
        //     "code": "BO"
        //     },
        //     {
        //     "name": "Bosnia and Herzegovina",
        //     "dial_code": "+387",
        //     "code": "BA"
        //     },
        //     {
        //     "name": "Botswana",
        //     "dial_code": "+267",
        //     "code": "BW"
        //     },
        //     {
        //     "name": "Brazil",
        //     "dial_code": "+55",
        //     "code": "BR"
        //     },
        //     {
        //     "name": "British Indian Ocean Territory",
        //     "dial_code": "+246",
        //     "code": "IO"
        //     },
        //     {
        //     "name": "Brunei Darussalam",
        //     "dial_code": "+673",
        //     "code": "BN"
        //     },
        //     {
        //     "name": "Bulgaria",
        //     "dial_code": "+359",
        //     "code": "BG"
        //     },
        //     {
        //     "name": "Burkina Faso",
        //     "dial_code": "+226",
        //     "code": "BF"
        //     },
        //     {
        //     "name": "Burundi",
        //     "dial_code": "+257",
        //     "code": "BI"
        //     },
        //     {
        //     "name": "Cambodia",
        //     "dial_code": "+855",
        //     "code": "KH"
        //     },
        //     {
        //     "name": "Cameroon",
        //     "dial_code": "+237",
        //     "code": "CM"
        //     },
        //     {
        //     "name": "Canada",
        //     "dial_code": "+1",
        //     "code": "CA"
        //     },
        //     {
        //     "name": "Cape Verde",
        //     "dial_code": "+238",
        //     "code": "CV"
        //     },
        //     {
        //     "name": "Cayman Islands",
        //     "dial_code": "+ 345",
        //     "code": "KY"
        //     },
        //     {
        //     "name": "Central African Republic",
        //     "dial_code": "+236",
        //     "code": "CF"
        //     },
        //     {
        //     "name": "Chad",
        //     "dial_code": "+235",
        //     "code": "TD"
        //     },
        //     {
        //     "name": "Chile",
        //     "dial_code": "+56",
        //     "code": "CL"
        //     },
        //     {
        //     "name": "China",
        //     "dial_code": "+86",
        //     "code": "CN"
        //     },
        //     {
        //     "name": "Christmas Island",
        //     "dial_code": "+61",
        //     "code": "CX"
        //     },
        //     {
        //     "name": "Cocos (Keeling) Islands",
        //     "dial_code": "+61",
        //     "code": "CC"
        //     },
        //     {
        //     "name": "Colombia",
        //     "dial_code": "+57",
        //     "code": "CO"
        //     },
        //     {
        //     "name": "Comoros",
        //     "dial_code": "+269",
        //     "code": "KM"
        //     },
        //     {
        //     "name": "Congo",
        //     "dial_code": "+242",
        //     "code": "CG"
        //     },
        //     {
        //     "name": "Congo, The Democratic Republic of the Congo",
        //     "dial_code": "+243",
        //     "code": "CD"
        //     },
        //     {
        //     "name": "Cook Islands",
        //     "dial_code": "+682",
        //     "code": "CK"
        //     },
        //     {
        //     "name": "Costa Rica",
        //     "dial_code": "+506",
        //     "code": "CR"
        //     },
        //     {
        //     "name": "Cote d'Ivoire",
        //     "dial_code": "+225",
        //     "code": "CI"
        //     },
        //     {
        //     "name": "Croatia",
        //     "dial_code": "+385",
        //     "code": "HR"
        //     },
        //     {
        //     "name": "Cuba",
        //     "dial_code": "+53",
        //     "code": "CU"
        //     },
        //     {
        //     "name": "Cyprus",
        //     "dial_code": "+357",
        //     "code": "CY"
        //     },
        //     {
        //     "name": "Czech Republic",
        //     "dial_code": "+420",
        //     "code": "CZ"
        //     },
        //     {
        //     "name": "Denmark",
        //     "dial_code": "+45",
        //     "code": "DK"
        //     },
        //     {
        //     "name": "Djibouti",
        //     "dial_code": "+253",
        //     "code": "DJ"
        //     },
        //     {
        //     "name": "Dominica",
        //     "dial_code": "+1767",
        //     "code": "DM"
        //     },
        //     {
        //     "name": "Dominican Republic",
        //     "dial_code": "+1849",
        //     "code": "DO"
        //     },
        //     {
        //     "name": "Ecuador",
        //     "dial_code": "+593",
        //     "code": "EC"
        //     },
        //     {
        //     "name": "Egypt",
        //     "dial_code": "+20",
        //     "code": "EG"
        //     },
        //     {
        //     "name": "El Salvador",
        //     "dial_code": "+503",
        //     "code": "SV"
        //     },
        //     {
        //     "name": "Equatorial Guinea",
        //     "dial_code": "+240",
        //     "code": "GQ"
        //     },
        //     {
        //     "name": "Eritrea",
        //     "dial_code": "+291",
        //     "code": "ER"
        //     },
        //     {
        //     "name": "Estonia",
        //     "dial_code": "+372",
        //     "code": "EE"
        //     },
        //     {
        //     "name": "Ethiopia",
        //     "dial_code": "+251",
        //     "code": "ET"
        //     },
        //     {
        //     "name": "Falkland Islands (Malvinas)",
        //     "dial_code": "+500",
        //     "code": "FK"
        //     },
        //     {
        //     "name": "Faroe Islands",
        //     "dial_code": "+298",
        //     "code": "FO"
        //     },
        //     {
        //     "name": "Fiji",
        //     "dial_code": "+679",
        //     "code": "FJ"
        //     },
        //     {
        //     "name": "Finland",
        //     "dial_code": "+358",
        //     "code": "FI"
        //     },
        //     {
        //     "name": "France",
        //     "dial_code": "+33",
        //     "code": "FR"
        //     },
        //     {
        //     "name": "French Guiana",
        //     "dial_code": "+594",
        //     "code": "GF"
        //     },
        //     {
        //     "name": "French Polynesia",
        //     "dial_code": "+689",
        //     "code": "PF"
        //     },
        //     {
        //     "name": "Gabon",
        //     "dial_code": "+241",
        //     "code": "GA"
        //     },
        //     {
        //     "name": "Gambia",
        //     "dial_code": "+220",
        //     "code": "GM"
        //     },
        //     {
        //     "name": "Georgia",
        //     "dial_code": "+995",
        //     "code": "GE"
        //     },
        //     {
        //     "name": "Germany",
        //     "dial_code": "+49",
        //     "code": "DE"
        //     },
        //     {
        //     "name": "Ghana",
        //     "dial_code": "+233",
        //     "code": "GH"
        //     },
        //     {
        //     "name": "Gibraltar",
        //     "dial_code": "+350",
        //     "code": "GI"
        //     },
        //     {
        //     "name": "Greece",
        //     "dial_code": "+30",
        //     "code": "GR"
        //     },
        //     {
        //     "name": "Greenland",
        //     "dial_code": "+299",
        //     "code": "GL"
        //     },
        //     {
        //     "name": "Grenada",
        //     "dial_code": "+1473",
        //     "code": "GD"
        //     },
        //     {
        //     "name": "Guadeloupe",
        //     "dial_code": "+590",
        //     "code": "GP"
        //     },
        //     {
        //     "name": "Guam",
        //     "dial_code": "+1671",
        //     "code": "GU"
        //     },
        //     {
        //     "name": "Guatemala",
        //     "dial_code": "+502",
        //     "code": "GT"
        //     },
        //     {
        //     "name": "Guernsey",
        //     "dial_code": "+44",
        //     "code": "GG"
        //     },
        //     {
        //     "name": "Guinea",
        //     "dial_code": "+224",
        //     "code": "GN"
        //     },
        //     {
        //     "name": "Guinea-Bissau",
        //     "dial_code": "+245",
        //     "code": "GW"
        //     },
        //     {
        //     "name": "Guyana",
        //     "dial_code": "+595",
        //     "code": "GY"
        //     },
        //     {
        //     "name": "Haiti",
        //     "dial_code": "+509",
        //     "code": "HT"
        //     },
        //     {
        //     "name": "Holy See (Vatican City State)",
        //     "dial_code": "+379",
        //     "code": "VA"
        //     },
        //     {
        //     "name": "Honduras",
        //     "dial_code": "+504",
        //     "code": "HN"
        //     },
        //     {
        //     "name": "Hong Kong",
        //     "dial_code": "+852",
        //     "code": "HK"
        //     },
        //     {
        //     "name": "Hungary",
        //     "dial_code": "+36",
        //     "code": "HU"
        //     },
        //     {
        //     "name": "Iceland",
        //     "dial_code": "+354",
        //     "code": "IS"
        //     },
        //     {
        //     "name": "India",
        //     "dial_code": "+91",
        //     "code": "IN"
        //     },
        //     {
        //     "name": "Indonesia",
        //     "dial_code": "+62",
        //     "code": "ID"
        //     },
        //     {
        //     "name": "Iran, Islamic Republic of Persian Gulf",
        //     "dial_code": "+98",
        //     "code": "IR"
        //     },
        //     {
        //     "name": "Iraq",
        //     "dial_code": "+964",
        //     "code": "IQ"
        //     },
        //     {
        //     "name": "Ireland",
        //     "dial_code": "+353",
        //     "code": "IE"
        //     },
        //     {
        //     "name": "Isle of Man",
        //     "dial_code": "+44",
        //     "code": "IM"
        //     },
        //     {
        //     "name": "Israel",
        //     "dial_code": "+972",
        //     "code": "IL"
        //     },
        //     {
        //     "name": "Italy",
        //     "dial_code": "+39",
        //     "code": "IT"
        //     },
        //     {
        //     "name": "Jamaica",
        //     "dial_code": "+1876",
        //     "code": "JM"
        //     },
        //     {
        //     "name": "Japan",
        //     "dial_code": "+81",
        //     "code": "JP"
        //     },
        //     {
        //     "name": "Jersey",
        //     "dial_code": "+44",
        //     "code": "JE"
        //     },
        //     {
        //     "name": "Jordan",
        //     "dial_code": "+962",
        //     "code": "JO"
        //     },
        //     {
        //     "name": "Kazakhstan",
        //     "dial_code": "+77",
        //     "code": "KZ"
        //     },
        //     {
        //     "name": "Kenya",
        //     "dial_code": "+254",
        //     "code": "KE"
        //     },
        //     {
        //     "name": "Kiribati",
        //     "dial_code": "+686",
        //     "code": "KI"
        //     },
        //     {
        //     "name": "Korea, Democratic People's Republic of Korea",
        //     "dial_code": "+850",
        //     "code": "KP"
        //     },
        //     {
        //     "name": "Korea, Republic of South Korea",
        //     "dial_code": "+82",
        //     "code": "KR"
        //     },
        //     {
        //     "name": "Kuwait",
        //     "dial_code": "+965",
        //     "code": "KW"
        //     },
        //     {
        //     "name": "Kyrgyzstan",
        //     "dial_code": "+996",
        //     "code": "KG"
        //     },
        //     {
        //     "name": "Laos",
        //     "dial_code": "+856",
        //     "code": "LA"
        //     },
        //     {
        //     "name": "Latvia",
        //     "dial_code": "+371",
        //     "code": "LV"
        //     },
        //     {
        //     "name": "Lebanon",
        //     "dial_code": "+961",
        //     "code": "LB"
        //     },
        //     {
        //     "name": "Lesotho",
        //     "dial_code": "+266",
        //     "code": "LS"
        //     },
        //     {
        //     "name": "Liberia",
        //     "dial_code": "+231",
        //     "code": "LR"
        //     },
        //     {
        //     "name": "Libyan Arab Jamahiriya",
        //     "dial_code": "+218",
        //     "code": "LY"
        //     },
        //     {
        //     "name": "Liechtenstein",
        //     "dial_code": "+423",
        //     "code": "LI"
        //     },
        //     {
        //     "name": "Lithuania",
        //     "dial_code": "+370",
        //     "code": "LT"
        //     },
        //     {
        //     "name": "Luxembourg",
        //     "dial_code": "+352",
        //     "code": "LU"
        //     },
        //     {
        //     "name": "Macao",
        //     "dial_code": "+853",
        //     "code": "MO"
        //     },
        //     {
        //     "name": "Macedonia",
        //     "dial_code": "+389",
        //     "code": "MK"
        //     },
        //     {
        //     "name": "Madagascar",
        //     "dial_code": "+261",
        //     "code": "MG"
        //     },
        //     {
        //     "name": "Malawi",
        //     "dial_code": "+265",
        //     "code": "MW"
        //     },
        //     {
        //     "name": "Malaysia",
        //     "dial_code": "+60",
        //     "code": "MY"
        //     },
        //     {
        //     "name": "Maldives",
        //     "dial_code": "+960",
        //     "code": "MV"
        //     },
        //     {
        //     "name": "Mali",
        //     "dial_code": "+223",
        //     "code": "ML"
        //     },
        //     {
        //     "name": "Malta",
        //     "dial_code": "+356",
        //     "code": "MT"
        //     },
        //     {
        //     "name": "Marshall Islands",
        //     "dial_code": "+692",
        //     "code": "MH"
        //     },
        //     {
        //     "name": "Martinique",
        //     "dial_code": "+596",
        //     "code": "MQ"
        //     },
        //     {
        //     "name": "Mauritania",
        //     "dial_code": "+222",
        //     "code": "MR"
        //     },
        //     {
        //     "name": "Mauritius",
        //     "dial_code": "+230",
        //     "code": "MU"
        //     },
        //     {
        //     "name": "Mayotte",
        //     "dial_code": "+262",
        //     "code": "YT"
        //     },
        //     {
        //     "name": "Mexico",
        //     "dial_code": "+52",
        //     "code": "MX"
        //     },
        //     {
        //     "name": "Micronesia, Federated States of Micronesia",
        //     "dial_code": "+691",
        //     "code": "FM"
        //     },
        //     {
        //     "name": "Moldova",
        //     "dial_code": "+373",
        //     "code": "MD"
        //     },
        //     {
        //     "name": "Monaco",
        //     "dial_code": "+377",
        //     "code": "MC"
        //     },
        //     {
        //     "name": "Mongolia",
        //     "dial_code": "+976",
        //     "code": "MN"
        //     },
        //     {
        //     "name": "Montenegro",
        //     "dial_code": "+382",
        //     "code": "ME"
        //     },
        //     {
        //     "name": "Montserrat",
        //     "dial_code": "+1664",
        //     "code": "MS"
        //     },
        //     {
        //     "name": "Morocco",
        //     "dial_code": "+212",
        //     "code": "MA"
        //     },
        //     {
        //     "name": "Mozambique",
        //     "dial_code": "+258",
        //     "code": "MZ"
        //     },
        //     {
        //     "name": "Myanmar",
        //     "dial_code": "+95",
        //     "code": "MM"
        //     },
        //     {
        //     "name": "Namibia",
        //     "dial_code": "+264",
        //     "code": "NA"
        //     },
        //     {
        //     "name": "Nauru",
        //     "dial_code": "+674",
        //     "code": "NR"
        //     },
        //     {
        //     "name": "Nepal",
        //     "dial_code": "+977",
        //     "code": "NP"
        //     },
        //     {
        //     "name": "Netherlands",
        //     "dial_code": "+31",
        //     "code": "NL"
        //     },
        //     {
        //     "name": "Netherlands Antilles",
        //     "dial_code": "+599",
        //     "code": "AN"
        //     },
        //     {
        //     "name": "New Caledonia",
        //     "dial_code": "+687",
        //     "code": "NC"
        //     },
        //     {
        //     "name": "New Zealand",
        //     "dial_code": "+64",
        //     "code": "NZ"
        //     },
        //     {
        //     "name": "Nicaragua",
        //     "dial_code": "+505",
        //     "code": "NI"
        //     },
        //     {
        //     "name": "Niger",
        //     "dial_code": "+227",
        //     "code": "NE"
        //     },
        //     {
        //     "name": "Nigeria",
        //     "dial_code": "+234",
        //     "code": "NG"
        //     },
        //     {
        //     "name": "Niue",
        //     "dial_code": "+683",
        //     "code": "NU"
        //     },
        //     {
        //     "name": "Norfolk Island",
        //     "dial_code": "+672",
        //     "code": "NF"
        //     },
        //     {
        //     "name": "Northern Mariana Islands",
        //     "dial_code": "+1670",
        //     "code": "MP"
        //     },
        //     {
        //     "name": "Norway",
        //     "dial_code": "+47",
        //     "code": "NO"
        //     },
        //     {
        //     "name": "Oman",
        //     "dial_code": "+968",
        //     "code": "OM"
        //     },
        //     {
        //     "name": "Pakistan",
        //     "dial_code": "+92",
        //     "code": "PK"
        //     },
        //     {
        //     "name": "Palau",
        //     "dial_code": "+680",
        //     "code": "PW"
        //     },
        //     {
        //     "name": "Palestinian Territory, Occupied",
        //     "dial_code": "+970",
        //     "code": "PS"
        //     },
        //     {
        //     "name": "Panama",
        //     "dial_code": "+507",
        //     "code": "PA"
        //     },
        //     {
        //     "name": "Papua New Guinea",
        //     "dial_code": "+675",
        //     "code": "PG"
        //     },
        //     {
        //     "name": "Paraguay",
        //     "dial_code": "+595",
        //     "code": "PY"
        //     },
        //     {
        //     "name": "Peru",
        //     "dial_code": "+51",
        //     "code": "PE"
        //     },
        //     {
        //     "name": "Philippines",
        //     "dial_code": "+63",
        //     "code": "PH"
        //     },
        //     {
        //     "name": "Pitcairn",
        //     "dial_code": "+872",
        //     "code": "PN"
        //     },
        //     {
        //     "name": "Poland",
        //     "dial_code": "+48",
        //     "code": "PL"
        //     },
        //     {
        //     "name": "Portugal",
        //     "dial_code": "+351",
        //     "code": "PT"
        //     },
        //     {
        //     "name": "Puerto Rico",
        //     "dial_code": "+1939",
        //     "code": "PR"
        //     },
        //     {
        //     "name": "Qatar",
        //     "dial_code": "+974",
        //     "code": "QA"
        //     },
        //     {
        //     "name": "Romania",
        //     "dial_code": "+40",
        //     "code": "RO"
        //     },
        //     {
        //     "name": "Russia",
        //     "dial_code": "+7",
        //     "code": "RU"
        //     },
        //     {
        //     "name": "Rwanda",
        //     "dial_code": "+250",
        //     "code": "RW"
        //     },
        //     {
        //     "name": "Reunion",
        //     "dial_code": "+262",
        //     "code": "RE"
        //     },
        //     {
        //     "name": "Saint Barthelemy",
        //     "dial_code": "+590",
        //     "code": "BL"
        //     },
        //     {
        //     "name": "Saint Helena, Ascension and Tristan Da Cunha",
        //     "dial_code": "+290",
        //     "code": "SH"
        //     },
        //     {
        //     "name": "Saint Kitts and Nevis",
        //     "dial_code": "+1869",
        //     "code": "KN"
        //     },
        //     {
        //     "name": "Saint Lucia",
        //     "dial_code": "+1758",
        //     "code": "LC"
        //     },
        //     {
        //     "name": "Saint Martin",
        //     "dial_code": "+590",
        //     "code": "MF"
        //     },
        //     {
        //     "name": "Saint Pierre and Miquelon",
        //     "dial_code": "+508",
        //     "code": "PM"
        //     },
        //     {
        //     "name": "Saint Vincent and the Grenadines",
        //     "dial_code": "+1784",
        //     "code": "VC"
        //     },
        //     {
        //     "name": "Samoa",
        //     "dial_code": "+685",
        //     "code": "WS"
        //     },
        //     {
        //     "name": "San Marino",
        //     "dial_code": "+378",
        //     "code": "SM"
        //     },
        //     {
        //     "name": "Sao Tome and Principe",
        //     "dial_code": "+239",
        //     "code": "ST"
        //     },
        //     {
        //     "name": "Saudi Arabia",
        //     "dial_code": "+966",
        //     "code": "SA"
        //     },
        //     {
        //     "name": "Senegal",
        //     "dial_code": "+221",
        //     "code": "SN"
        //     },
        //     {
        //     "name": "Serbia",
        //     "dial_code": "+381",
        //     "code": "RS"
        //     },
        //     {
        //     "name": "Seychelles",
        //     "dial_code": "+248",
        //     "code": "SC"
        //     },
        //     {
        //     "name": "Sierra Leone",
        //     "dial_code": "+232",
        //     "code": "SL"
        //     },
        //     {
        //     "name": "Singapore",
        //     "dial_code": "+65",
        //     "code": "SG"
        //     },
        //     {
        //     "name": "Slovakia",
        //     "dial_code": "+421",
        //     "code": "SK"
        //     },
        //     {
        //     "name": "Slovenia",
        //     "dial_code": "+386",
        //     "code": "SI"
        //     },
        //     {
        //     "name": "Solomon Islands",
        //     "dial_code": "+677",
        //     "code": "SB"
        //     },
        //     {
        //     "name": "Somalia",
        //     "dial_code": "+252",
        //     "code": "SO"
        //     },
        //     {
        //     "name": "South Africa",
        //     "dial_code": "+27",
        //     "code": "ZA"
        //     },
        //     {
        //     "name": "South Sudan",
        //     "dial_code": "+211",
        //     "code": "SS"
        //     },
        //     {
        //     "name": "South Georgia and the South Sandwich Islands",
        //     "dial_code": "+500",
        //     "code": "GS"
        //     },
        //     {
        //     "name": "Spain",
        //     "dial_code": "+34",
        //     "code": "ES"
        //     },
        //     {
        //     "name": "Sri Lanka",
        //     "dial_code": "+94",
        //     "code": "LK"
        //     },
        //     {
        //     "name": "Sudan",
        //     "dial_code": "+249",
        //     "code": "SD"
        //     },
        //     {
        //     "name": "Suriname",
        //     "dial_code": "+597",
        //     "code": "SR"
        //     },
        //     {
        //     "name": "Svalbard and Jan Mayen",
        //     "dial_code": "+47",
        //     "code": "SJ"
        //     },
        //     {
        //     "name": "Swaziland",
        //     "dial_code": "+268",
        //     "code": "SZ"
        //     },
        //     {
        //     "name": "Sweden",
        //     "dial_code": "+46",
        //     "code": "SE"
        //     },
        //     {
        //     "name": "Switzerland",
        //     "dial_code": "+41",
        //     "code": "CH"
        //     },
        //     {
        //     "name": "Syrian Arab Republic",
        //     "dial_code": "+963",
        //     "code": "SY"
        //     },
        //     {
        //     "name": "Taiwan",
        //     "dial_code": "+886",
        //     "code": "TW"
        //     },
        //     {
        //     "name": "Tajikistan",
        //     "dial_code": "+992",
        //     "code": "TJ"
        //     },
        //     {
        //     "name": "Tanzania, United Republic of Tanzania",
        //     "dial_code": "+255",
        //     "code": "TZ"
        //     },
        //     {
        //     "name": "Thailand",
        //     "dial_code": "+66",
        //     "code": "TH"
        //     },
        //     {
        //     "name": "Timor-Leste",
        //     "dial_code": "+670",
        //     "code": "TL"
        //     },
        //     {
        //     "name": "Togo",
        //     "dial_code": "+228",
        //     "code": "TG"
        //     },
        //     {
        //     "name": "Tokelau",
        //     "dial_code": "+690",
        //     "code": "TK"
        //     },
        //     {
        //     "name": "Tonga",
        //     "dial_code": "+676",
        //     "code": "TO"
        //     },
        //     {
        //     "name": "Trinidad and Tobago",
        //     "dial_code": "+1868",
        //     "code": "TT"
        //     },
        //     {
        //     "name": "Tunisia",
        //     "dial_code": "+216",
        //     "code": "TN"
        //     },
        //     {
        //     "name": "Turkey",
        //     "dial_code": "+90",
        //     "code": "TR"
        //     },
        //     {
        //     "name": "Turkmenistan",
        //     "dial_code": "+993",
        //     "code": "TM"
        //     },
        //     {
        //     "name": "Turks and Caicos Islands",
        //     "dial_code": "+1649",
        //     "code": "TC"
        //     },
        //     {
        //     "name": "Tuvalu",
        //     "dial_code": "+688",
        //     "code": "TV"
        //     },
        //     {
        //     "name": "Uganda",
        //     "dial_code": "+256",
        //     "code": "UG"
        //     },
        //     {
        //     "name": "Ukraine",
        //     "dial_code": "+380",
        //     "code": "UA"
        //     },
        //     {
        //     "name": "United Arab Emirates",
        //     "dial_code": "+971",
        //     "code": "AE"
        //     },
        //     {
        //     "name": "United Kingdom",
        //     "dial_code": "+44",
        //     "code": "GB"
        //     },
        //     {
        //     "name": "United States",
        //     "dial_code": "+1",
        //     "code": "US"
        //     },
        //     {
        //     "name": "Uruguay",
        //     "dial_code": "+598",
        //     "code": "UY"
        //     },
        //     {
        //     "name": "Uzbekistan",
        //     "dial_code": "+998",
        //     "code": "UZ"
        //     },
        //     {
        //     "name": "Vanuatu",
        //     "dial_code": "+678",
        //     "code": "VU"
        //     },
        //     {
        //     "name": "Venezuela, Bolivarian Republic of Venezuela",
        //     "dial_code": "+58",
        //     "code": "VE"
        //     },
        //     {
        //     "name": "Vietnam",
        //     "dial_code": "+84",
        //     "code": "VN"
        //     },
        //     {
        //     "name": "Virgin Islands, British",
        //     "dial_code": "+1284",
        //     "code": "VG"
        //     },
        //     {
        //     "name": "Virgin Islands, U.S.",
        //     "dial_code": "+1340",
        //     "code": "VI"
        //     },
        //     {
        //     "name": "Wallis and Futuna",
        //     "dial_code": "+681",
        //     "code": "WF"
        //     },
        //     {
        //     "name": "Yemen",
        //     "dial_code": "+967",
        //     "code": "YE"
        //     },
        //     {
        //     "name": "Zambia",
        //     "dial_code": "+260",
        //     "code": "ZM"
        //     },
        //     {
        //     "name": "Zimbabwe",
        //     "dial_code": "+263",
        //     "code": "ZW"
        //     }
        // ]);
    }
}

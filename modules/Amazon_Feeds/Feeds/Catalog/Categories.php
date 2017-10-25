<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/* * ***************************************************************************\
  +-----------------------------------------------------------------------------+
  | X-Cart Software license agreement                                           |
  | Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>         |
  | All rights reserved.                                                        |
  +-----------------------------------------------------------------------------+
  | PLEASE READ  THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "COPYRIGHT" |
  | FILE PROVIDED WITH THIS DISTRIBUTION. THE AGREEMENT TEXT IS ALSO AVAILABLE  |
  | AT THE FOLLOWING URL: https://www.x-cart.com/license-agreement-classic.html |
  |                                                                             |
  | THIS AGREEMENT EXPRESSES THE TERMS AND CONDITIONS ON WHICH YOU MAY USE THIS |
  | SOFTWARE PROGRAM AND ASSOCIATED DOCUMENTATION THAT QUALITEAM SOFTWARE LTD   |
  | (hereinafter referred to as "THE AUTHOR") OF REPUBLIC OF CYPRUS IS          |
  | FURNISHING OR MAKING AVAILABLE TO YOU WITH THIS AGREEMENT (COLLECTIVELY,    |
  | THE "SOFTWARE"). PLEASE REVIEW THE FOLLOWING TERMS AND CONDITIONS OF THIS   |
  | LICENSE AGREEMENT CAREFULLY BEFORE INSTALLING OR USING THE SOFTWARE. BY     |
  | INSTALLING, COPYING OR OTHERWISE USING THE SOFTWARE, YOU AND YOUR COMPANY   |
  | (COLLECTIVELY, "YOU") ARE ACCEPTING AND AGREEING TO THE TERMS OF THIS       |
  | LICENSE AGREEMENT. IF YOU ARE NOT WILLING TO BE BOUND BY THIS AGREEMENT, DO |
  | NOT INSTALL OR USE THE SOFTWARE. VARIOUS COPYRIGHTS AND OTHER INTELLECTUAL  |
  | PROPERTY RIGHTS PROTECT THE SOFTWARE. THIS AGREEMENT IS A LICENSE AGREEMENT |
  | THAT GIVES YOU LIMITED RIGHTS TO USE THE SOFTWARE AND NOT AN AGREEMENT FOR  |
  | SALE OR FOR TRANSFER OF TITLE. THE AUTHOR RETAINS ALL RIGHTS NOT EXPRESSLY  |
  | GRANTED BY THIS AGREEMENT.                                                  |
  +-----------------------------------------------------------------------------+
  \**************************************************************************** */

/**
 * Categories
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Michael Bugrov
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    d64b9edd8b1b9c64b9fe8c8756002b5bae68c892, v8 (xcart_4_7_8), 2017-05-12 19:55:55, Categories.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

namespace XCart\Modules\AmazonFeeds\Feeds\Catalog;

class Categories extends \XC_Singleton {

	protected $cats = array (// <editor-fold desc="Categories" defaultstate="collapsed">{{{
      'Arts' => 
      array (
        'ProductType' => 
        array (
          0 => 'FineArt',
          1 => 'FineArtEditioned',
        ),
      ),
      'AutoAccessory' => 
      array (
        'ProductType' => 
        array (
          0 => 'AutoAccessoryMisc',
          1 => 'AutoPart',
          2 => 'PowersportsPart',
          3 => 'PowersportsVehicle',
          4 => 'ProtectiveGear',
          5 => 'Helmet',
          6 => 'RidingApparel',
          7 => 'Tire',
          8 => 'Rims',
          9 => 'TireAndWheel',
          10 => 'Vehicle',
          11 => 'Motorcyclepart',
          12 => 'Motorcycleaccessory',
          13 => 'Ridinggloves',
          14 => 'Ridingboots',
          15 => 'Autooil',
          16 => 'Autobattery',
          17 => 'Autochemical',
          18 => 'CleaningOrRepairKit',
        ),
      ),
      'Baby' => 
      array (
        'ProductType' => 
        array (
          0 => 'BabyProducts',
        ),
      ),
      'Beauty' => 
      array (
        'ProductType' => 
        array (
          0 => 'BeautyMisc',
        ),
      ),
      'Books' => 
      array (
        'ProductType' => 
        array (
          'BooksMisc' => 
          array (
            'Binding' => 
            array (
              0 => 'Accessory',
              1 => 'Album',
              2 => 'Audiocd',
              3 => 'Audiodownload',
              4 => 'Bathbook',
              5 => 'Boardbook',
              6 => 'Bondedleather',
              7 => 'Calendar',
              8 => 'Cardbook',
              9 => 'Cards',
              10 => 'Cassette',
              11 => 'Cdrom',
              12 => 'Comic',
              13 => 'Diary',
              14 => 'Dvdrom',
              15 => 'Flexibound',
              16 => 'Foambook',
              17 => 'Game',
              18 => 'Hardcover',
              19 => 'Hardcovercomic',
              20 => 'Hardcoverspiral',
              21 => 'Imitationleather',
              22 => 'Journal',
              23 => 'Kindleedition',
              24 => 'Leatherbound',
              25 => 'Library',
              26 => 'Libraryaudiocd',
              27 => 'Libraryaudiomp3',
              28 => 'Looseleaf',
              29 => 'Map',
              30 => 'Massmarket',
              31 => 'Microfiche',
              32 => 'Microfilm',
              33 => 'Miscsupplies',
              34 => 'Mook',
              35 => 'Mp3cd',
              36 => 'Pamphlet',
              37 => 'Paperback',
              38 => 'Paperbackbunko',
              39 => 'Paperbackshinsho',
              40 => 'Perfect',
              41 => 'Plasticcomb',
              42 => 'Popup',
              43 => 'Preloadeddigitalaudioplayer',
              44 => 'Ragbook',
              45 => 'Ringbound',
              46 => 'Roughcut',
              47 => 'School',
              48 => 'Sheetmusic',
              49 => 'Singleissuemagazine',
              50 => 'Slide',
              51 => 'Spiralbound',
              52 => 'Stationery',
              53 => 'Tankobonhardcover',
              54 => 'Tankobonsoftcover',
              55 => 'Textbook',
              56 => 'Toy',
              57 => 'Transparency',
              58 => 'Turtleback',
              59 => 'Unbound',
              60 => 'Vinylbound',
              61 => 'Wallchart',
              62 => 'Workbook',
            ),
          ),
        ),
      ),
      'CE' => 
      array (
        'ProductType' => 
        array (
          0 => 'Antenna',
          1 => 'AudioVideoAccessory',
          2 => 'AVFurniture',
          3 => 'BarCodeReader',
          4 => 'CEBinocular',
          5 => 'CECamcorder',
          6 => 'CameraBagsAndCases',
          7 => 'CEBattery',
          8 => 'CEBlankMedia',
          9 => 'CableOrAdapter',
          10 => 'CECameraFlash',
          11 => 'CameraLenses',
          12 => 'CameraOtherAccessories',
          13 => 'CameraPowerSupply',
          14 => 'CarAlarm',
          15 => 'CarAudioOrTheater',
          16 => 'CarElectronics',
          17 => 'ConsumerElectronics',
          18 => 'CEDigitalCamera',
          19 => 'DigitalPictureFrame',
          20 => 'DigitalVideoRecorder',
          21 => 'DVDPlayerOrRecorder',
          22 => 'CEFilmCamera',
          23 => 'GPSOrNavigationAccessory',
          24 => 'GPSOrNavigationSystem',
          25 => 'HandheldOrPDA',
          26 => 'Headphones',
          27 => 'HomeTheaterSystemOrHTIB',
          28 => 'KindleAccessories',
          29 => 'KindleEReaderAccessories',
          30 => 'KindleFireAccessories',
          31 => 'MediaPlayer',
          32 => 'MediaPlayerOrEReaderAccessory',
          33 => 'MediaStorage',
          34 => 'MiscAudioComponents',
          35 => 'PC',
          36 => 'PDA',
          37 => 'Phone',
          38 => 'PhoneAccessory',
          39 => 'PhotographicStudioItems',
          40 => 'PortableAudio',
          41 => 'PortableAvDevice',
          42 => 'PowerSuppliesOrProtection',
          43 => 'RadarDetector',
          44 => 'RadioOrClockRadio',
          45 => 'ReceiverOrAmplifier',
          46 => 'RemoteControl',
          47 => 'Speakers',
          48 => 'StereoShelfSystem',
          49 => 'CETelescope',
          50 => 'Television',
          51 => 'Tuner',
          52 => 'TVCombos',
          53 => 'TwoWayRadio',
          54 => 'VCR',
          55 => 'CEVideoProjector',
          56 => 'VideoProjectorsAndAccessories',
        ),
      ),
      'CameraPhoto' => 
      array (
        'ProductType' => 
        array (
          0 => 'FilmCamera',
          1 => 'Camcorder',
          2 => 'DigitalCamera',
          3 => 'DigitalFrame',
          4 => 'Binocular',
          5 => 'SurveillanceSystem',
          6 => 'Telescope',
          7 => 'Microscope',
          8 => 'Darkroom',
          9 => 'Lens',
          10 => 'LensAccessory',
          11 => 'Filter',
          12 => 'Film',
          13 => 'BagCase',
          14 => 'BlankMedia',
          15 => 'PhotoPaper',
          16 => 'Cleaner',
          17 => 'Flash',
          18 => 'TripodStand',
          19 => 'Lighting',
          20 => 'Projection',
          21 => 'PhotoStudio',
          22 => 'LightMeter',
          23 => 'PowerSupply',
          24 => 'OtherAccessory',
        ),
      ),
      'Coins' => 
      array (
        'ProductType' => 
        array (
          0 => 'Coin',
          1 => 'CollectibleCoins',
          2 => 'Bullion',
        ),
      ),
      'Collectibles' => 
      array (
        'ProductType' => 
        array (
          0 => 'AdvertisementCollectibles',
          1 => 'HistoricalCollectibles',
        ),
      ),
      'Computers' => 
      array (
        'ProductType' => 
        array (
          0 => 'CarryingCaseOrBag',
          1 => 'ComputerAddOn',
          2 => 'ComputerComponent',
          3 => 'ComputerCoolingDevice',
          4 => 'ComputerDriveOrStorage',
          5 => 'ComputerInputDevice',
          6 => 'ComputerProcessor',
          7 => 'ComputerSpeaker',
          8 => 'Computer',
          9 => 'FlashMemory',
          10 => 'InkOrToner',
          11 => 'Keyboards',
          12 => 'MemoryReader',
          13 => 'Monitor',
          14 => 'Motherboard',
          15 => 'NetworkingDevice',
          16 => 'NotebookComputer',
          17 => 'PersonalComputer',
          18 => 'Printer',
          19 => 'RamMemory',
          20 => 'Scanner',
          21 => 'SoundCard',
          22 => 'SystemCabinet',
          23 => 'SystemPowerDevice',
          24 => 'TabletComputer',
          25 => 'VideoCard',
          26 => 'VideoProjector',
          27 => 'Webcam',
        ),
      ),
      'EducationSupplies' => 
      array (
        'ProductType' => 
        array (
          0 => 'TeachingEquipment',
        ),
      ),
      'EntertainmentCollectibles' => 
      array (
        'ProductType' => 
        array (
          0 => 'EntertainmentMemorabilia',
        ),
      ),
      'FoodAndBeverages' => 
      array (
        'ProductType' => 
        array (
          0 => 'Food',
          1 => 'HouseholdSupplies',
          2 => 'Beverages',
          3 => 'HardLiquor',
          4 => 'AlcoholicBeverages',
          5 => 'Wine',
          6 => 'Beer',
          7 => 'Spirits',
        ),
      ),
      'FoodServiceAndJanSan' => 
      array (
        'ProductType' => 
        array (
          0 => 'FoodServiceAndJanSan',
        ),
      ),
      'Furniture' => 
      array (
        'ProductType' => 
        array (
          0 => 'Furniture',
        ),
      ),
      'GiftCard' => 
      array (
        'ProductType' => 
        array (
          0 => 'GiftCard',
          1 => 'PhysicalGiftCard',
          2 => 'ElectronicGiftCard',
        ),
      ),
      'Gourmet' => 
      array (
        'ProductType' => 
        array (
          0 => 'GourmetMisc',
        ),
      ),
      'Health' => 
      array (
        'ProductType' => 
        array (
          0 => 'HealthMisc',
          1 => 'PersonalCareAppliances',
          2 => 'PrescriptionDrug',
        ),
      ),
      'Home' => 
      array (
        'ProductType' => 
        array (
          0 => 'BedAndBath',
          1 => 'FurnitureAndDecor',
          2 => 'Kitchen',
          3 => 'OutdoorLiving',
          4 => 'SeedsAndPlants',
          5 => 'Art',
          6 => 'Home',
        ),
      ),
      'HomeImprovement' => 
      array (
        'ProductType' => 
        array (
          0 => 'BuildingMaterials',
          1 => 'Hardware',
          2 => 'Electrical',
          3 => 'PlumbingFixtures',
          4 => 'Tools',
          5 => 'OrganizersAndStorage',
          6 => 'MajorHomeAppliances',
          7 => 'SecurityElectronics',
        ),
      ),
      'Industrial' => 
      array (
        'ProductType' => 
        array (
          0 => 'Abrasives',
          1 => 'AdhesivesAndSealants',
          2 => 'CuttingTools',
          3 => 'ElectronicComponents',
          4 => 'Gears',
          5 => 'Grommets',
          6 => 'IndustrialHose',
          7 => 'IndustrialWheels',
          8 => 'MechanicalComponents',
          9 => 'ORings',
          10 => 'PrecisionMeasuring',
        ),
      ),
      'Jewelry' => 
      array (
        'ProductType' => 
        array (
          0 => 'Watch',
          1 => 'FashionNecklaceBraceletAnklet',
          2 => 'FashionRing',
          3 => 'FashionEarring',
          4 => 'FashionOther',
          5 => 'FineNecklaceBraceletAnklet',
          6 => 'FineRing',
          7 => 'FineEarring',
          8 => 'FineOther',
        ),
      ),
      'LabSupplies' => 
      array (
        'ProductType' => 
        array (
          0 => 'LabSupply',
          1 => 'SafetySupply',
        ),
      ),
      'LargeAppliances' => 
      array (
        'ProductType' => 
        array (
          0 => 'AirConditioner',
          1 => 'ApplianceAccessory',
          2 => 'CookingOven',
          3 => 'Cooktop',
          4 => 'Dishwasher',
          5 => 'LaundryAppliance',
          6 => 'MicrowaveOven',
          7 => 'Range',
          8 => 'RefrigerationAppliance',
          9 => 'TrashCompactor',
          10 => 'VentHood',
        ),
      ),
      'Lighting' => 
      array (
        'ProductType' => 
        array (
          0 => 'LightsAndFixtures',
          1 => 'LightingAccessories',
          2 => 'LightBulbs',
        ),
      ),
      'Luggage' => 
      array (
        'ProductType' => 
        array (
          0 => 'Luggage',
        ),
      ),
      'LuxuryBeauty' => 
      array (
        'ProductType' => 
        array (
          0 => 'LuxuryBeauty',
        ),
      ),
      'MechanicalFasteners' => 
      array (
        'ProductType' => 
        array (
          0 => 'MechanicalFasteners',
        ),
      ),
      'Miscellaneous' => 
      array (
        '_simple_string_ProductType' => 
        array (
          0 => 'Antiques',
          1 => 'Art',
          2 => 'Car_Parts_and_Accessories',
          3 => 'Coins',
          4 => 'Collectibles',
          5 => 'Crafts',
          6 => 'Event_Tickets',
          7 => 'Flowers',
          8 => 'Gifts_and_Occasions',
          9 => 'Gourmet_Food_and_Wine',
          10 => 'Hobbies',
          11 => 'Home_Furniture_and_Decor',
          12 => 'Home_Lighting_and_Lamps',
          13 => 'Home_Organizers_and_Storage',
          14 => 'Jewelry_and_Gems',
          15 => 'Luggage',
          16 => 'Major_Home_Appliances',
          17 => 'Medical_Supplies',
          18 => 'Motorcycles',
          19 => 'Musical_Instruments',
          20 => 'Pet_Supplies',
          21 => 'Pottery_and_Glass',
          22 => 'Prints_and_Posters',
          23 => 'Scientific_Supplies',
          24 => 'Sporting_and_Outdoor_Goods',
          25 => 'Sports_Memorabilia',
          26 => 'Stamps',
          27 => 'Teaching_and_School_Supplies',
          28 => 'Watches',
          29 => 'Wholesale_and_Industrial',
          30 => 'Misc_Other',
        ),
      ),
      'Motorcycles' => 
      array (
        'ProductType' => 
        array (
          0 => 'Vehicles',
          1 => 'ProtectiveClothing',
          2 => 'Helmets',
          3 => 'RidingBoots',
          4 => 'Gloves',
          5 => 'Accessories',
          6 => 'Parts',
        ),
      ),
      'Music' => 
      array (
        'ProductType' => 
        array (
          0 => 'MusicPopular',
          1 => 'MusicClassical',
        ),
      ),
      'MusicalInstruments' => 
      array (
        'ProductType' => 
        array (
          0 => 'BrassAndWoodwindInstruments',
          1 => 'Guitars',
          2 => 'InstrumentPartsAndAccessories',
          3 => 'KeyboardInstruments',
          4 => 'MiscWorldInstruments',
          5 => 'PercussionInstruments',
          6 => 'SoundAndRecordingEquipment',
          7 => 'StringedInstruments',
        ),
      ),
      'Office' => 
      array (
        'ProductType' => 
        array (
          0 => 'ArtSupplies',
          1 => 'EducationalSupplies',
          2 => 'OfficeProducts',
          3 => 'PaperProducts',
          4 => 'WritingInstruments',
          5 => 'BarCode',
          6 => 'Calculator',
          7 => 'InkToner',
          8 => 'MultifunctionDevice',
          9 => 'OfficeElectronics',
          10 => 'OfficePhone',
          11 => 'OfficePrinter',
          12 => 'OfficeScanner',
          13 => 'VoiceRecorder',
        ),
      ),
      'Outdoors' => 
      array (
        'ProductType' => 
        array (
          0 => 'OutdoorRecreationProduct',
        ),
      ),
      'PetSupplies' => 
      array (
        'ProductType' => 
        array (
          0 => 'PetSuppliesMisc',
        ),
      ),
      'PowerTransmission' => 
      array (
        'ProductType' => 
        array (
          0 => 'BearingsAndBushings',
          1 => 'Belts',
          2 => 'CompressionSprings',
          3 => 'ExtensionSprings',
          4 => 'FlexibleCouplings',
          5 => 'Gears',
          6 => 'RigidCouplings',
          7 => 'ShaftCollar',
          8 => 'TorsionSprings',
          9 => 'LinearGuidesAndRails',
          10 => 'Pulleys',
          11 => 'RollerChain',
          12 => 'CouplingsCollarsAndUniversalJoints',
          13 => 'Springs',
          14 => 'Sprockets',
          15 => 'UniversalJoints',
        ),
      ),
      'ProfessionalHealthCare' => 
      array (
        'ProductType' => 
        array (
          0 => 'ProfessionalHealthCare',
        ),
      ),
      'RawMaterials' => 
      array (
        'ProductType' => 
        array (
          0 => 'CeramicBalls',
          1 => 'CeramicTubing',
          2 => 'Ceramics',
          3 => 'MetalBalls',
          4 => 'MetalMesh',
          5 => 'MetalTubing',
          6 => 'Metals',
          7 => 'PlasticBalls',
          8 => 'PlasticMesh',
          9 => 'PlasticTubing',
          10 => 'Plastics',
          11 => 'RawMaterials',
          12 => 'Wire',
        ),
      ),
      'Shoes' => 
      array (
        'ClothingType' => 
        array (
          0 => 'Accessory',
          1 => 'Bag',
          2 => 'Shoes',
          3 => 'ShoeAccessory',
          4 => 'Handbag',
          5 => 'Eyewear',
        ),
      ),
      'SoftwareVideoGames' => 
      array (
        'ProductType' => 
        array (
          0 => 'Software',
          1 => 'HandheldSoftwareDownloads',
          2 => 'SoftwareGames',
          3 => 'VideoGames',
          4 => 'VideoGamesAccessories',
          5 => 'VideoGamesHardware',
        ),
      ),
      'Sports' => 
      array (
        'ProductType' => 
        array (
          0 => 'SportingGoods',
          1 => 'GolfClubHybrid',
          2 => 'GolfClubIron',
          3 => 'GolfClubPutter',
          4 => 'GolfClubWedge',
          5 => 'GolfClubWood',
          6 => 'GolfClubs',
        ),
      ),
      'SportsMemorabilia' => 
      array (
        'ProductType' => 
        array (
          0 => 'SportsMemorabilia',
          1 => 'TradingCardsCardsSets',
          2 => 'TradingCardsGradedCardsInserts',
          3 => 'TradingCardsUngradedInserts',
          4 => 'TradingCardsFactorySealed',
          5 => 'TradingCardsMiscTradingCards',
        ),
      ),
      'ThreeDPrinting' => 
      array (
        'ProductType' => 
        array (
          0 => 'DigitalDesigns',
          1 => 'ThreeDPrintedProduct',
          2 => 'ThreeDPrintableDesigns',
        ),
      ),
      'TiresAndWheels' => 
      array (
        'ProductType' => 
        array (
          0 => 'Tires',
          1 => 'Wheels',
          2 => 'TireAndWheelAssemblies',
        ),
      ),
      'Toys' => 
      array (
        'ProductType' => 
        array (
          0 => 'ToysAndGames',
          1 => 'Hobbies',
          2 => 'CollectibleCard',
          3 => 'Costume',
        ),
      ),
      'ToysBaby' => 
      array (
        'ProductType' => 
        array (
          0 => 'ToysAndGames',
          1 => 'BabyProducts',
        ),
      ),
      'Video' => 
      array (
        'ProductType' => 
        array (
          0 => 'VideoDVD',
          1 => 'VideoVHS',
        ),
      ),
      'WineAndAlcohol' => 
      array (
        'ProductType' => 
        array (
          0 => 'Wine',
          1 => 'Spirits',
          2 => 'Beer',
        ),
      ),
      'Wireless' => 
      array (
        'ProductType' => 
        array (
          0 => 'WirelessAccessories',
          1 => 'WirelessDownloads',
        ),
      ),
    );
    //}}} </editor-fold>

    public function getCategories()
    { // {{{
        return $this->cats;
    } // }}}

    public function getFlattenCategories()
    { // {{{
        static $result = array();

        if (!empty($result)) { return $result; }

        $iterator = function ($elements, &$result, $path = '', $code = 0, $level = 0) use (&$iterator) {
            if (is_array($elements)) {
                foreach ($elements as $key => $element) {
                    if ($level === 0) {
                        $code = $key;
                    }
                    if (is_numeric($key)) {
                        $key = $element;
                    }
                    $separator = !empty($path) ? \XCAmazonFeedsDefs::FEED_PATH_DELIMITER : '';

                    $iterator($element, $result, $path . $separator . $key, $code, $level + 1);
                }
            } else {
                $result[$code][$path] = $elements;
            }
        };

        $iterator($this->cats, $result);

        return $result;
    } // }}}

    public static function getInstance()
    { // {{{
        // Call parent getter
        return parent::getClassInstance(__CLASS__);
    } // }}}

}

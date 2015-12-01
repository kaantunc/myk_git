<?php
defined('_JEXEC') or die('Restricted access');

		$conf =& JFactory::getConfig();
			
		$host = $conf->getValue('config.oracleHost');
		$port = $conf->getValue('config.oraclePort');
		$service = $conf->getValue('config.oracleServiceName');
		$db_username = $conf->getValue('config.oracleUser');
		$db_password = $conf->getValue('config.oraclePassword');
			
		$tns = "
			(DESCRIPTION =
				(ADDRESS_LIST =
					(ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
				)
				(CONNECT_DATA =
					(SERVICE_NAME = $service)
				)
			)
			";
			
		try{
			$connection = new PDO("oci:dbname=".$tns,$db_username,$db_password);
			// hatalar� g�rmek i�in a�a��daki sat�r� uncomment yap
			$connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		}catch(PDOException $e){
			echo ($e->getMessage());
		}

//  $query = 'CREATE TABLE "drupal_install_test" ("id" NUMBER(38) NOT NULL, "blob" CLOB)';
//  $stmt = $connection->prepare($query);
//  $stmt->execute();


  //$stmt->bindValue(':id', 3);
  $blob = "VAROLAN YETKİNLİK: İNTES, meslek standardı hazırlama konusundaki çalışmalarını yürütmek için kendi bünyesinde istihdam ettiği personelin yanı sıra üye kuruluşlarında çalışan uzmanlardan da yararlanmaktadır. Yapılan çalışmalarda aynı zamanda MEGEP uzmanlarından da destek alınmaktadır. Bu kapsamdaki çalışmalarını,  2004 yılından bu yana yürüttüğü AB projeleri ile de aktif olarak sürdürmektedir. İNTES ayrıca 1994 yılında İŞKUR tarafından yürütülen ve Dünya Bankası tarafından finanse edilen meslek standartları belirlemem çalışmalarında da destek vermiştir. 

İNTES, meslek standartlarını oluşturmak üzere aşağıdaki projeleri yürütmüştür. Bu projeler ile meslek standartları çalışmasının altyapısını oluşturmayı hedeflemiştir:

1- LDV Eğiticilerin Eğitimi Projesi
2- İŞKUR Projeleri ( iki adet) Bu projelerde mesleki eğitimin yanısıra meslek standartları çalışması da Alman ortak ile yürütülmüştür. Almanya’da meslek standartlarının nasıl yapıldığı incelenmiştir. Ve anket çalışması sonucunda belirlenen öncelikli mesleklerin yeterlilik çalışması gerçekleştirilmiştir. Anket ekte sunulmuştur. 
3- MEGEP projeleri; iki adet proje ile doğrudan meslek standardı çalışması yapılmış, proje personeli meslek standardı hazırlanması konusunda kısa süreli eğitim almıştır. Projeler ile ölçme ve değerlendirme ve sınav sistemi için de pilot çalışmalar yapılmıştır.
4- MEGEP uzmanları ile iki adet meslek standardı geliştirilmiştir (MEGEP tarafından hazırlanan geniş kapsamlı format doğrultusunda). 

Bu konuda çalışmak üzere İNTES’te tam ve yarı zamanlı bir uzman kadrosu bulunmakta olup, çalışmalar için bir ekip oluşturulmuştur. Bu ekip MEGEP ile 2 mesleğin standartlarının hazırlanmasında aktif olarak görev almıştır. Çalışmalarda yer alan kişilere ait sertifikalar ekte sunulmuştur.  

İNTES, bu çalışmaları yaparken, ayrıca meslek bazında dış uzmanların ve ilgili kurum/kuruluşların da görüşünü almıştır.

YAPILACAKLAR: 

İNTES, meslek standartları çalışmasının devamını, ilgili tüm taraflardan oluşacak bir komite ile yürütecektir. Meslek standartları çalışmasının koordinasyonu İNTES Genel Sekreterliği ve Merkezde istihdam edilen kişi tarafından yürütülecektir.  İNTES var olan uzman kadrosunu daha etkin hale getirmek için bu konuda uzman bir kişiyi yalnızca bu alanda çalışmak ve çalışmalara doğrudan destek vermek üzere ek olarak istihdam edecektir. İstihdam edilecek olan uzman, aynı zamanda sürecin koordine edilmesine de destek verecektir. 

İNTES bünyesinde meslek standartları için özel bir birim kurulmuş olup bu birim altında çalışacak olan uzmanlar öncelikle kısa süreli, sonrasında da sürekli olarak istihdam edilecektir. Bu uzmanların meslek standartları hazırlama konusunda eğitilmeleri sağlanacaktır. Bu uzmanların bir kısmı daha önce gerek projeler gerekse MEGEP ile hazırlanan meslek standartlarında görev almışlardır. Bu eğitimin MEB Projeler Koordinasyon Merkezi uzmanlarından alınması planlanmaktadır.

AROLAN YETKİNLİK: İNTES, meslek standardı hazırlama konusundaki çalışmalarını yürütmek için kendi bünyesinde istihdam ettiği personelin yanı sıra üye kuruluşlarında çalışan uzmanlardan da yararlanmaktadır. Yapılan çalışmalarda aynı zamanda MEGEP uzmanlarından da destek alınmaktadır. Bu kapsamdaki çalışmalarını,  2004 yılından bu yana yürüttüğü AB projeleri ile de aktif olarak sürdürmektedir. İNTES ayrıca 1994 yılında İŞKUR tarafından yürütülen ve Dünya Bankası tarafından finanse edilen meslek standartları belirlemem çalışmalarında da destek vermiştir. 

İNTES, meslek standartlarını oluşturmak üzere aşağıdaki projeleri yürütmüştür. Bu projeler ile meslek standartları çalışmasının altyapısını oluşturmayı hedeflemiştir:

1- LDV Eğiticilerin Eğitimi Projesi
2- İŞKUR Projeleri ( iki adet) Bu projelerde mesleki eğitimin yanısıra meslek standartları çalışması da Alman ortak ile yürütülmüştür. Almanya’da meslek standartlarının nasıl yapıldığı incelenmiştir. Ve anket çalışması sonucunda belirlenen öncelikli mesleklerin yeterlilik çalışması gerçekleştirilmiştir. Anket ekte sunulmuştur. 
3- MEGEP projeleri; iki adet proje ile doğrudan meslek standardı çalışması yapılmış, proje personeli meslek standardı hazırlanması konusunda kısa süreli eğitim almıştır. Projeler ile ölçme ve değerlendirme ve sınav sistemi için de pilot çalışmalar yapılmıştır.
4- MEGEP uzmanları ile iki adet meslek standardı geliştirilmiştir (MEGEP tarafından hazırlanan geniş kapsamlı format doğrultusunda). 

Bu konuda çalışmak üzere İNTES’te tam ve yarı zamanlı bir uzman kadrosu bulunmakta olup, çalışmalar için bir ekip oluşturulmuştur. Bu ekip MEGEP ile 2 mesleğin standartlarının hazırlanmasında aktif olarak görev almıştır. Çalışmalarda yer alan kişilere ait sertifikalar ekte sunulmuştur.  

İNTES, bu çalışmaları yaparken, ayrıca meslek bazında dış uzmanların ve ilgili kurum/kuruluşların da görüşünü almıştır.

YAPILACAKLAR: 

İNTES, meslek standartları çalışmasının devamını, ilgili tüm taraflardan oluşacak bir komite ile yürütecektir. Meslek standartları çalışmasının koordinasyonu İNTES Genel Sekreterliği ve Merkezde istihdam edilen kişi tarafından yürütülecektir.  İNTES var olan uzman kadrosunu daha etkin hale getirmek için bu konuda uzman bir kişiyi yalnızca bu alanda çalışmak ve çalışmalara doğrudan destek vermek üzere ek olarak istihdam edecektir. İstihdam edilecek olan uzman, aynı zamanda sürecin koordine edilmesine de destek verecektir. 

İNTES bünyesinde meslek standartları için özel bir birim kurulmuş olup bu birimAROLAN YETKİNLİK: İNTES, meslek standardı hazırlama konusundaki çalışmalarını yürütmek için kendi bünyesinde istihdam ettiği personelin yanı sıra üye kuruluşlarında çalışan uzmanlardan da yararlanmaktadır. Yapılan çalışmalarda aynı zamanda MEGEP uzmanlarından da destek alınmaktadır. Bu kapsamdaki çalışmalarını,  2004 yılından bu yana yürüttüğü AB projeleri ile de aktif olarak sürdürmektedir. İNTES ayrıca 1994 yılında İŞKUR tarafından yürütülen ve Dünya Bankası tarafından finanse edilen meslek standartları belirlemem çalışmalarında da destek vermiştir. 

İNTES, meslek standartlarını oluşturmak üzere aşağıdaki projeleri yürütmüştür. Bu projeler ile meslek standartları çalışmasının altyapısını oluşturmayı hedeflemiştir:

1- LDV Eğiticilerin Eğitimi Projesi
2- İŞKUR Projeleri ( iki adet) Bu projelerde mesleki eğitimin yanısıra meslek standartları çalışması da Alman ortak ile yürütülmüştür. Almanya’da meslek standartlarının nasıl yapıldığı incelenmiştir. Ve anket çalışması sonucunda belirlenen öncelikli mesleklerin yeterlilik çalışması gerçekleştirilmiştir. Anket ekte sunulmuştur. 
3- MEGEP projeleri; iki adet proje ile doğrudan meslek standardı çalışması yapılmış, proje personeli meslek standardı hazırlanması konusunda kısa süreli eğitim almıştır. Projeler ile ölçme ve değerlendirme ve sınav sistemi için de pilot çalışmalar yapılmıştır.
4- MEGEP uzmanları ile iki adet meslek standardı geliştirilmiştir (MEGEP tarafından hazırlanan geniş kapsamlı format doğrultusunda). 

Bu konuda çalışmak üzere İNTES’te tam ve yarı zamanlı bir uzman kadrosu bulunmakta olup, çalışmalar için bir ekip oluşturulmuştur. Bu ekip MEGEP ile 2 mesleğin standartlarının hazırlanmasında aktif olarak görev almıştır. Çalışmalarda yer alan kişilere ait sertifikalar ekte sunulmuştur.  

İNTES, bu çalışmaları yaparken, ayrıca meslek bazında dış uzmanların ve ilgili kurum/kuruluşların da görüşünü almıştır.

YAPILACAKLAR: 

İNTES, meslek standartları çalışmasının devamını, ilgili tüm taraflardan oluşacak bir komite ile yürütecektir. Meslek standartları çalışmasının koordinasyonu İNTES Genel Sekreterliği ve Merkezde istihdam edilen kişi tarafından yürütülecektir.  İNTES var olan uzman kadrosunu daha etkin hale getirmek için bu konuda uzman bir kişiyi yalnızca bu alanda çalışmak ve çalışmalara doğrudan destek vermek üzere ek olarak istihdam edecektir. İstihdam edilecek olan uzman, aynı zamanda sürecin koordine edilmesine de destek verecektir. 

İNTES bünyesinde meslek standartları için özel bir birim kurulmuş olup bu birimAROLAN YETKİNLİK: İNTES, meslek standardı hazırlama konusundaki çalışmalarını yürütmek için kendi bünyesinde istihdam ettiği personelin yanı sıra üye kuruluşlarında çalışan uzmanlardan da yararlanmaktadır. Yapılan çalışmalarda aynı zamanda MEGEP uzmanlarından da destek alınmaktadır. Bu kapsamdaki çalışmalarını,  2004 yılından bu yana yürüttüğü AB projeleri ile de aktif olarak sürdürmektedir. İNTES ayrıca 1994 yılında İŞKUR tarafından yürütülen ve Dünya Bankası tarafından finanse edilen meslek standartları belirlemem çalışmalarında da destek vermiştir. 

İNTES, meslek standartlarını oluşturmak üzere aşağıdaki projeleri yürütmüştür. Bu projeler ile meslek standartları çalışmasının altyapısını oluşturmayı hedeflemiştir:

1- LDV Eğiticilerin Eğitimi Projesi
2- İŞKUR Projeleri ( iki adet) Bu projelerde mesleki eğitimin yanısıra meslek standartları çalışması da Alman ortak ile yürütülmüştür. Almanya’da meslek standartlarının nasıl yapıldığı incelenmiştir. Ve anket çalışması sonucunda belirlenen öncelikli mesleklerin yeterlilik çalışması gerçekleştirilmiştir. Anket ekte sunulmuştur. 
3- MEGEP projeleri; iki adet proje ile doğrudan meslek standardı çalışması yapılmış, proje personeli meslek standardı hazırlanması konusunda kısa süreli eğitim almıştır. Projeler ile ölçme ve değerlendirme ve sınav sistemi için de pilot çalışmalar yapılmıştır.
4- MEGEP uzmanları ile iki adet meslek standardı geliştirilmiştir (MEGEP tarafından hazırlanan geniş kapsamlı format doğrultusunda). 

Bu konuda çalışmak üzere İNTES’te tam ve yarı zamanlı bir uzman kadrosu bulunmakta olup, çalışmalar için bir ekip oluşturulmuştur. Bu ekip MEGEP ile 2 mesleğin standartlarının hazırlanmasında aktif olarak görev almıştır. Çalışmalarda yer alan kişilere ait sertifikalar ekte sunulmuştur.  

İNTES, bu çalışmaları yaparken, ayrıca meslek bazında dış uzmanların ve ilgili kurum/kuruluşların da görüşünü almıştır.

YAPILACAKLAR: 

İNTES, meslek standartları çalışmasının devamını, ilgili tüm taraflardan oluşacak bir komite ile yürütecektir. Meslek standartları çalışmasının koordinasyonu İNTES Genel Sekreterliği ve Merkezde istihdam edilen kişi tarafından yürütülecektir.  İNTES var olan uzman kadrosunu daha etkin hale getirmek için bu konuda uzman bir kişiyi yalnızca bu alanda çalışmak ve çalışmalara doğrudan destek vermek üzere ek olarak istihdam edecektir. İstihdam edilecek olan uzman, aynı zamanda sürecin koordine edilmesine de destek verecektir. 

İNTES bünyesinde meslek standartları için özel bir birim kurulmuş olup bu birimAROLAN YETKİNLİK: İNTES, meslek standardı hazırlama konusundaki çalışmalarını yürütmek için kendi bünyesinde istihdam ettiği personelin yanı sıra üye kuruluşlarında çalışan uzmanlardan da yararlanmaktadır. Yapılan çalışmalarda aynı zamanda MEGEP uzmanlarından da destek alınmaktadır. Bu kapsamdaki çalışmalarını,  2004 yılından bu yana yürüttüğü AB projeleri ile de aktif olarak sürdürmektedir. İNTES ayrıca 1994 yılında İŞKUR tarafından yürütülen ve Dünya Bankası tarafından finanse edilen meslek standartları belirlemem çalışmalarında da destek vermiştir. 

İNTES, meslek standartlarını oluşturmak üzere aşağıdaki projeleri yürütmüştür. Bu projeler ile meslek standartları çalışmasının altyapısını oluşturmayı hedeflemiştir:

1- LDV Eğiticilerin Eğitimi Projesi
2- İŞKUR Projeleri ( iki adet) Bu projelerde mesleki eğitimin yanısıra meslek standartları çalışması da Alman ortak ile yürütülmüştür. Almanya’da meslek standartlarının nasıl yapıldığı incelenmiştir. Ve anket çalışması sonucunda belirlenen öncelikli mesleklerin yeterlilik çalışması gerçekleştirilmiştir. Anket ekte sunulmuştur. 
3- MEGEP projeleri; iki adet proje ile doğrudan meslek standardı çalışması yapılmış, proje personeli meslek standardı hazırlanması konusunda kısa süreli eğitim almıştır. Projeler ile ölçme ve değerlendirme ve sınav sistemi için de pilot çalışmalar yapılmıştır.
4- MEGEP uzmanları ile iki adet meslek standardı geliştirilmiştir (MEGEP tarafından hazırlanan geniş kapsamlı format doğrultusunda). 

Bu konuda çalışmak üzere İNTES’te tam ve yarı zamanlı bir uzman kadrosu bulunmakta olup, çalışmalar için bir ekip oluşturulmuştur. Bu ekip MEGEP ile 2 mesleğin standartlarının hazırlanmasında aktif olarak görev almıştır. Çalışmalarda yer alan kişilere ait sertifikalar ekte sunulmuştur.  

İNTES, bu çalışmaları yaparken, ayrıca meslek bazında dış uzmanların ve ilgili kurum/kuruluşların da görüşünü almıştır.

YAPILACAKLAR: 

İNTES, meslek standartları çalışmasının devamını, ilgili tüm taraflardan oluşacak bir komite ile yürütecektir. Meslek standartları çalışmasının koordinasyonu İNTES Genel Sekreterliği ve Merkezde istihdam edilen kişi tarafından yürütülecektir.  İNTES var olan uzman kadrosunu daha etkin hale getirmek için bu konuda uzman bir kişiyi yalnızca bu alanda çalışmak ve çalışmalara doğrudan destek vermek üzere ek olarak istihdam edecektir. İstihdam edilecek olan uzman, aynı zamanda sürecin koordine edilmesine de destek verecektir. 

İNTES bünyesinde meslek standartları için özel bir birim kurulmuş olup bu birim";
  $id = 54321;
  $query = 'INSERT INTO "drupal_install_test" ("id", "blob") VALUES (?, ?)';
  $stmt = $connection->prepare($query); 
  $stmt->bindParam(1, $id, PDO::PARAM_STR, strlen($id));
  $stmt->bindParam(2, $blob, PDO::PARAM_STR, strlen($blob));
  $connection->beginTransaction();
  $stmt->execute();
  $connection->commit();

//  $query = 'SELECT * FROM "drupal_install_test" WHERE "id" = 1';
//  $stmt = $connection->prepare($query);
//  $stmt->execute();
//  $object = $stmt->fetch(PDO::FETCH_OBJ);
//  $blob = stream_get_contents($object->blob);
//  var_dump($blob);

//  $query = 'UPDATE "drupal_install_test" SET "blob" = EMPTY_CLOB() WHERE "id" = :id RETURNING "blob" INTO :blob';
//  $stmt = $connection->prepare($query);
//  $stmt->bindValue(':id', 1);
//  $stmt->bindParam(':blob', $blob, PDO::PARAM_LOB);
//  $blob = NULL;
//  $connection->beginTransaction();
//  $stmt->execute();
//  var_dump($blob);
//  fwrite($blob, "This is a BLOB UPDATE action");
//  fclose($blob);
//  $connection->commit();

//  $query = 'SELECT * FROM "drupal_install_test" WHERE "id" = 1';
//  $stmt = $connection->prepare($query);
//  $stmt->execute();
//  $object = $stmt->fetch(PDO::FETCH_OBJ);
//  $blob = stream_get_contents($object->blob);
//  var_dump($blob);

//  $query = 'DROP TABLE "drupal_install_test"';
//  $stmt = $connection->prepare($query);
//  $stmt->execute();
  exit;
?>
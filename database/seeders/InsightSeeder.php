<?php

namespace Database\Seeders;

use App\Models\Insight;
use Illuminate\Database\Seeder;

class InsightSeeder extends Seeder
{
    public function run(): void
    {
        $publishedAt = now()->subDays(3);
        $items = [
            ['strategic-capital-beyond-the-cheque','Strategic capital beyond the cheque','A practical way to evaluate what an investor can contribute beyond money.','images/approved/insight-msme-hd.webp','Modern Indian business district representing MSME growth','Strategic capital'],
            ['equity-readiness-for-established-businesses','Equity readiness for established businesses','The financial, governance and ownership questions to resolve before an equity raise.','images/approved/insight-capital-hd.webp','Business leaders discussing strategic capital','MSME equity'],
            ['transaction-discipline-in-ma','Transaction discipline in M&A','Why preparation, confidentiality and counterpart fit matter before a deal enters the market.','images/approved/insight-ma-hd.webp','Executive document and pen representing transaction discipline','M&A'],
        ];
        foreach ($items as $index => [$slug,$title,$summary,$cover,$alt,$category]) {
            Insight::updateOrCreate(['slug'=>$slug], [
                'title'=>$title, 'summary'=>$summary, 'body'=>$summary,
                'cover_image'=>$cover, 'alt_text'=>$alt, 'author'=>'Bridge India Capital',
                'category'=>$category, 'status'=>'published', 'featured'=>true,
                'published_at'=>(clone $publishedAt)->subDays($index),
                'seo_title'=>$title.' | Bridge India Capital', 'seo_description'=>$summary,
            ]);
        }
    }
}


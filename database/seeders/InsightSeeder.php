<?php

namespace Database\Seeders;

use App\Models\Insight;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InsightSeeder extends Seeder
{
    public function run(): void
    {
        Insight::truncate();

        $articles = [
            [
                'title' => 'Strategic Capital Beyond the Cheque: Evaluating Investor Value-Add in India',
                'category' => 'Strategic Capital',
                'author' => 'Bridge India Capital Committee',
                'status' => 'published',
                'featured' => true,
                'days_ago' => 1,
                'summary' => 'A rigorous framework for founders and promoters to evaluate what an institutional or family office investor truly contributes beyond capital.',
                'body' => "## The Real Currency in Strategic Capital

In mature private market ecosystems, capital is rapidly commoditised. What separates enduring institutional value creation from mere ownership dilution is strategic alignment.

### Three Dimensions of True Value-Add

1. **Market Access & Distribution Corridors:** Can the capital partner open Tier-1 OEM doors, regulatory pathways or export logistics that would otherwise take 3-5 years to build organically?
2. **Governance Rigour without Operational Strangulation:** Effective board members provide risk insulation, clean audit trails, and independent scrutiny without second-guessing daily operating decisions.
3. **Syndicate & Follow-on Anchor Capacity:** Founders must assess whether the incoming investor has dry powder or sovereign and institutional relationships for subsequent rounds.

### Conclusion

Before signing term sheets, promoters should treat investor reference checks with the same discipline investors apply to management audits.",
            ],
            [
                'title' => 'Equity Readiness for Established MSMEs: The Pre-Capital Checklist',
                'category' => 'MSME Equity',
                'author' => 'Advisory Practice Group',
                'status' => 'published',
                'featured' => true,
                'days_ago' => 3,
                'summary' => 'The critical financial, governance and operational questions Indian manufacturing and trading MSMEs must resolve before inviting external equity.',
                'body' => "## Transitioning from Proprietary to Institutional Architecture

Many profitable Indian MSMEs reach a revenue plateau between ₹25 Cr and ₹100 Cr. Breaking past this threshold almost universally demands structured growth capital. However, external equity requires a structural mindset shift.

### Pillars of Equity Readiness

- **Financial Segregation:** Disentangling personal assets, family expenses, and sister-entity transactions from operating EBITDA.
- **Related-Party Transaction Rationalisation:** Clear, arm’s-length transfer pricing protocols that will withstand rigorous Big-4 forensic diligence.
- **Second-Line Leadership:** Establishing functional heads across sales, plant operations, and finance rather than single-promoter reliance.",
            ],
            [
                'title' => 'Transaction Discipline in Indian Mid-Market M&A',
                'category' => 'M&A Advisory',
                'author' => 'M&A Advisory Desk',
                'status' => 'published',
                'featured' => true,
                'days_ago' => 5,
                'summary' => 'Why preparation, strict confidentiality and strategic counterpart alignment matter long before a transaction enters the formal market.',
                'body' => "## Eliminating Deal Friction Before Market Launch

In cross-border and domestic mid-market M&A, more transactions fail due to information asymmetry and emotional wear-out than commercial valuation disagreements.

### Managing Information Asymmetry

A prepared data room with normalised EBITDA adjustments, environmental compliance sign-offs, and customer concentration contracts reduces deal gestation by an average of 4.5 months. Strict non-disclosure enforcement preserves supplier leverage throughout bilateral negotiations.",
            ],
            [
                'title' => 'The Rise of Domestic Family Offices in Indian Private Equity',
                'category' => 'Strategic Capital',
                'author' => 'Siddharth Mehra & BIC Research',
                'status' => 'published',
                'featured' => false,
                'days_ago' => 7,
                'summary' => 'How second and third-generation Indian industrial families are pivoting from real estate and public equities toward direct private equity co-investments.',
                'body' => "## The Structural Shift in Wealth Allocation

Over the past five years, domestic family offices across Mumbai, Delhi NCR, Ahmedabad and Bengaluru have institutionalised their investment mandates. 

Direct direct equity ownership in capital-goods manufacturing, consumer supply chains, and B2B tech has outpaced passive fund allocation. Their patience for 7-10 year capital cycles makes them ideal partners for MSMEs wary of aggressive 3-year private equity fund exit pressures.",
            ],
            [
                'title' => 'Valuation Realism in Seed and Pre-Series A Funding Rounds',
                'category' => 'Venture Growth',
                'author' => 'Venture Analysis Team',
                'status' => 'published',
                'featured' => false,
                'days_ago' => 9,
                'summary' => 'Navigating the valuation recalibration in early-stage Indian ventures and aligning burn rates with verifiable gross margin expansion.',
                'body' => "## Beyond Topline GMV: The Return to Fundamentals

Founders who raised at peak multiples in 2021-2022 face complex recapitalisation conversations today. The prevailing market demands clear customer contribution margins and payback periods under 14 months. Raising at realistic valuations protects founding team ownership and avoids onerous liquidation preference structures.",
            ],
            [
                'title' => 'SME IPO vs. Private Growth Equity: Making the Strategic Choice',
                'category' => 'MSME Equity',
                'author' => 'Capital Markets Desk',
                'status' => 'published',
                'featured' => false,
                'days_ago' => 11,
                'summary' => 'A comparative financial and operational analysis between listing on BSE SME / NSE Emerge versus onboarding a private strategic equity fund.',
                'body' => "## Choosing Your Capital Pathway

The burgeoning liquidity on the NSE Emerge and BSE SME platforms has created an attractive listing route for companies with operating profit above ₹3 Cr. 

However, public market compliance, continuous disclosures, and illiquid trading blocks must be balanced against the strategic industry depth and international networks that dedicated private equity sponsors bring to the boardroom table.",
            ],
            [
                'title' => 'Navigating Vendor Due Diligence: Lessons from Recent Deal Closures',
                'category' => 'M&A Advisory',
                'author' => 'M&A Transaction Team',
                'status' => 'published',
                'featured' => false,
                'days_ago' => 14,
                'summary' => 'Why commissioning sell-side vendor diligence accelerates deal velocity and prevents re-trading during exclusivity periods.',
                'body' => "## Taking Control of the Sell-Side Narrative

Vendor Due Diligence (VDD) empowers the seller to identify and rectify historical compliance vulnerabilities before external buyers discover them. It establishes a credible baseline EBITDA and significantly curtails protracted escrow and indemnity demands.",
            ],
            [
                'title' => 'Supply Chain Decoupling: India’s Manufacturing Window of Opportunity',
                'category' => 'Market Intelligence',
                'author' => 'Macro Strategy Desk',
                'status' => 'published',
                'featured' => false,
                'days_ago' => 18,
                'summary' => 'Analyzing global corporate procurement shifts towards India in electronics, specialty chemicals and precision engineering components.',
                'body' => "## The China+1 Reality on Indian Factory Floors

Multinational supply chain diversification is accelerating capital expenditure commitments in industrial hubs across Tamil Nadu, Gujarat and Maharashtra. MSMEs with quality certifications (AS9100, IATF 16949) are securing long-term multi-year master supply agreements.",
            ],
            [
                'title' => 'Corporate Governance Frameworks for Pre-Institutional Companies',
                'category' => 'Corporate Governance',
                'author' => 'Governance Practice Lead',
                'status' => 'draft',
                'featured' => false,
                'days_ago' => 20,
                'summary' => 'Practical steps for privately held mid-market entities to institute effective audit committees and independent director oversight.',
                'body' => "## Professionalising the Boardroom

Draft paper examining internal audit charters, statutory auditor rotation, whistleblowing protocols, and delegation of financial authorities in family-led enterprises prior to institutional capital intake.",
            ],
            [
                'title' => 'Structured Debt as a Non-Dilutive Capital Bridge',
                'category' => 'Strategic Capital',
                'author' => 'Credit Solutions Group',
                'status' => 'draft',
                'featured' => false,
                'days_ago' => 22,
                'summary' => 'How mezzanine financing, revenue-based financing, and structured holding company debt can fuel expansion without immediate equity dilution.',
                'body' => "## Balancing Leverage and Equity Preservation

Internal draft analyzing hybrid instruments, cash-flow coverage ratios, and personal guarantee carve-outs for capital-intensive infrastructure and contract manufacturing projects.",
            ],
            [
                'title' => 'Historical Analysis: 2023 Cross-Border Technology Acquisitions',
                'category' => 'M&A Advisory',
                'author' => 'Historical Deal Archives',
                'status' => 'archived',
                'featured' => false,
                'days_ago' => 45,
                'summary' => 'Retrospective study of Indian IT services tuck-in acquisitions across North America and DACH region during the 2023 fiscal year.',
                'body' => "## Archived Market Briefing

Archived analysis documenting multiples paid, earn-out structures, and post-merger integration metrics across 28 mid-market technology transactions.",
            ],
            [
                'title' => 'Legacy Industrial Real Estate Liquidation Best Practices',
                'category' => 'Corporate Governance',
                'author' => 'Special Situations Group',
                'status' => 'archived',
                'featured' => false,
                'days_ago' => 60,
                'summary' => 'Structuring surplus factory land monetization through state industrial development corporation transfer approvals.',
                'body' => "## Archived Reference Guide

Legacy guidelines on stamp duty optimisation and industrial land lease conversions in non-core asset rationalisation.",
            ],
        ];

        // Add additional synthetic articles to ensure total count > 28 so pagination (25 per page) activates!
        $topics = [
            ['CleanTech Energy Storage Financing Trends', 'Strategic Capital', 'Analysis of grid-scale battery storage equity commitments.'],
            ['Cross-Border Tax Treaties and Inbound FDI Structuring', 'Corporate Governance', 'Navigating DTAA protocols, Place of Effective Management (POEM) rules and GAAR.'],
            ['Working Capital Optimization in Export-Oriented Units', 'MSME Equity', 'Inventory turnover benchmarks and export credit guarantee agency programs.'],
            ['Secondary Share Sales: Providing Liquidity to Angel Syndicates', 'Venture Growth', 'Mechanisms for founder and early employee secondary buybacks in Series B rounds.'],
            ['Post-Merger Operational Integration: The First 100 Days', 'M&A Advisory', 'Synergy realization, cultural alignment, and unified ERP integration blueprints.'],
            ['Direct-to-Consumer Brand Consolidation Playbooks', 'Market Intelligence', 'House-of-brands rollups and shared manufacturing supply chain efficiencies.'],
            ['Healthcare Infra Capex: Multi-Speciality Expansion in Tier-2 Cities', 'Strategic Capital', 'Demographic demand models driving hospital project financing across India.'],
            ['AI Integration in B2B Procurement Diligence', 'Market Intelligence', 'Leveraging automated invoice reconciliation and vendor telemetry during audits.'],
            ['Commercial Contracts and Material Adverse Change Clauses', 'Corporate Governance', 'Legal drafting safeguards for prospective buyers during macroeconomic volatility.'],
            ['Defense Indigenisation: Capital Needs of Precision Defense MSMEs', 'MSME Equity', 'Capitalizing on iDEX initiatives and defense offset manufacturing mandates.'],
            ['Automated Warehousing: Capex Returns and Financing Models', 'Strategic Capital', 'Robotic sortation systems ROI and equipment leasing structures.'],
            ['Specialty Chemicals: Environmental ESG Audits in European M&A', 'M&A Advisory', 'Zero liquid discharge compliance as a deal breaker in global chemical divestitures.'],
            ['Fintech Underwriting Compliance: RBI Digital Lending Directives', 'Market Intelligence', 'First-loss default guarantees and regulatory capital requirements for non-banks.'],
            ['Promoter Succession Planning and Family Constitutions', 'Corporate Governance', 'Structuring generational transfer of operating control and voting rights.'],
            ['Infrastructure Trust (InvIT) Feasibility for Green Energy Assets', 'Strategic Capital', 'Asset pooling and dividend yield expectations in renewable energy portfolios.'],
            ['Agritech Cold Chain Logistics: Capital Efficiency Benchmarks', 'MSME Equity', 'Reefer fleet utilisation rates and farmgate aggregation economies of scale.'],
            ['Software M&A Earnout Structures in Volatile Currency Regimes', 'M&A Advisory', 'Hedging foreign exchange risk in cross-border earnouts and milestone payments.'],
            ['Debt Syndication Strategies for Greenfield Industrial Corridors', 'Strategic Capital', 'Consortium banking arrangements and lead bank negotiation tactics.'],
        ];

        $authors = ['BIC Research', 'Investment Committee', 'Advisory Practice Group', 'Siddharth Mehra', 'M&A Advisory Desk'];
        $statuses = ['published', 'published', 'published', 'draft', 'published', 'archived'];

        foreach ($topics as $index => [$title, $category, $summary]) {
            $days = 5 + $index * 3;
            $status = $statuses[$index % count($statuses)];
            $author = $authors[$index % count($authors)];

            $articles[] = [
                'title' => $title,
                'category' => $category,
                'author' => $author,
                'status' => $status,
                'featured' => false,
                'days_ago' => $days,
                'summary' => $summary,
                'body' => "## Executive Summary: {$title}\n\nThis insight briefing evaluates key quantitative benchmarks, transaction structures, and strategic implications for market participants.\n\n### Analytical Framework\n\n- Detailed risk evaluation and capital efficiency criteria.\n- Comparative study of precedent transactions in the Indian industrial ecosystem.\n- Concrete governance and execution steps for managing partners.",
            ];
        }

        $covers = [
            'images/approved/insight-msme-hd.webp',
            'images/approved/insight-capital-hd.webp',
            'images/approved/insight-ma-hd.webp',
            'images/approved/hero-hd.webp',
        ];

        foreach ($articles as $index => $item) {
            $slug = Str::slug($item['title']);
            $date = now()->subDays($item['days_ago'])->subHours($index % 12);
            $cover = $covers[$index % count($covers)];

            Insight::create([
                'title' => $item['title'],
                'slug' => $slug,
                'summary' => $item['summary'],
                'body' => $item['body'],
                'cover_image' => $cover,
                'alt_text' => 'Bridge India Capital Insight - ' . $item['category'],
                'author' => $item['author'],
                'category' => $item['category'],
                'status' => $item['status'],
                'featured' => $item['featured'],
                'published_at' => $item['status'] === 'published' ? $date : null,
                'seo_title' => $item['title'] . ' | Bridge India Capital',
                'seo_description' => Str::limit($item['summary'], 155),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}

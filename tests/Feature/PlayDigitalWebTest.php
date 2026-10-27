<?php

namespace Tests\Feature;

use App\Models\ContactInquiry;
use App\Models\Work;
use Database\Seeders\PlayDigitalSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayDigitalWebTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PlayDigitalSeeder::class);
    }

    public function test_home_page_renders_showreel_portfolio_about_rules_services_and_footer(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('gBPHuwaHQQc')
            ->assertSee('Turn on our ideas, Let’s play to win')
            ->assertSee('TTB เปลี่ยนกันวันนี้')
            ->assertSee('Bangchak')
            ->assertSee('แร็ปหรอยแรง 4 ภาค!')
            ->assertSee('A Total Digital Driven Experience!')
            ->assertSee('Top form players')
            ->assertSee('Website Design')
            ->assertSee('Brand Monitoring & Tracking System')
            ->assertSee('Park Silom Tower');
    }

    public function test_work_index_and_category_routes_support_slugs_and_legacy_ids(): void
    {
        $this->get('/work')
            ->assertOk()
            ->assertSee('VIDEO CAMPAIGN')
            ->assertSee('WEB DESIGN & DEVELOPMENT')
            ->assertSee('Sriraja Panich')
            ->assertSee('The taste of the original');

        $this->get('/work/category/video-campaign')
            ->assertOk()
            ->assertSee('VIDEO CAMPAIGN')
            ->assertSee('TTB เปลี่ยนกันวันนี้');

        // Legacy numeric cid=1 -> WEB DESIGN & DEVELOPMENT
        $this->get('/work/category/1')
            ->assertOk()
            ->assertSee('WEB DESIGN & DEVELOPMENT')
            ->assertSee('CP Catering Services');
    }

    public function test_work_detail_renders_video_and_gallery_items_by_slug_or_legacy_id(): void
    {
        $this->get('/work/bangchak-rap-4-regions')
            ->assertOk()
            ->assertSee('Bangchak')
            ->assertSee('แร็ปหรอยแรง 4 ภาค!')
            ->assertSee('eU_fkTMxv-M')
            ->assertSee('Bangchak Corporation PCL');

        // Legacy numeric id=16 -> Sriraja Panich website
        $this->get('/work/16')
            ->assertOk()
            ->assertSee('Sriraja Panich')
            ->assertSee('The taste of the original')
            ->assertSee('Thaitheparos PCL');
    }

    public function test_clients_page_renders_all_32_brand_logos(): void
    {
        $response = $this->get('/clients');

        $response->assertOk()->assertSee('CLIENTS');
        $response->assertSee('images/logo_clients/1.png');
        $response->assertSee('images/logo_clients/32.png');
    }

    public function test_blog_and_contact_pages_render_cleanly(): void
    {
        $this->get('/blog')
            ->assertOk()
            ->assertSee('BLOG')
            ->assertSee('A Total Digital Driven Experience');

        $this->get('/blog/total-digital-driven-experience')
            ->assertOk()
            ->assertSee('Digital Strategy');

        $this->get('/contact')
            ->assertOk()
            ->assertSee('CONTACT US')
            ->assertSee('09 8859 4453');
    }

    public function test_legacy_playdigital_query_urls_redirect_cleanly(): void
    {
        $ttb = Work::where('legacy_id', 92)->firstOrFail();

        $this->get('/?page=work')->assertRedirect('/work');
        $this->get('/?page=clients')->assertRedirect('/clients');
        $this->get('/?page=category&cid=2')->assertRedirect('/work/category/video-campaign');
        $this->get('/?page=detail-work&id=84')->assertRedirect('/work/bangchak-rap-4-regions');
        $this->get('/?page=detail-vdo&id=92')->assertRedirect('/work/' . $ttb->slug);
        $this->get('/index.php?page=clients')->assertRedirect('/clients');
    }

    public function test_contact_form_stores_inquiry_via_html_and_json_and_validates_inputs(): void
    {
        // HTML POST
        $htmlResponse = $this->from('/contact')->post('/contact', [
            'name' => 'สมชาย ใจดี',
            'email' => 'somchai@example.co.th',
            'phone' => '081-234-5678',
            'company' => 'Example Thailand Co., Ltd.',
            'service_interest' => 'Website Design & Development',
            'message' => 'ต้องการปรึกษาการพัฒนาเว็บไซต์บริษัทและแคมเปญโฆษณาออนไลน์ครบวงจรครับ',
        ]);

        $htmlResponse->assertRedirect('/contact#contact');
        $htmlResponse->assertSessionHas('contact_success');

        $this->assertDatabaseHas('contact_inquiries', [
            'name' => 'สมชาย ใจดี',
            'email' => 'somchai@example.co.th',
            'company' => 'Example Thailand Co., Ltd.',
            'status' => 'new',
        ]);

        // JSON AJAX POST
        $jsonResponse = $this->postJson('/contact', [
            'name' => 'Kanya Marketing',
            'email' => 'kanya@brand.co.th',
            'phone' => '0899998888',
            'company' => 'Brand Co., Ltd.',
            'service_interest' => 'Viral Campaign',
            'message' => 'สนใจทำแคมเปญวิดีโอไวรัลเปิดตัวสินค้าใหม่ในไตรมาสหน้าค่ะ',
        ]);

        $jsonResponse->assertCreated()
            ->assertJsonStructure(['message', 'inquiry_id']);

        $this->assertSame(2, ContactInquiry::count());

        // Validation error
        $invalidResponse = $this->postJson('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => 'hi',
        ]);

        $invalidResponse->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'message']);
    }

    public function test_contact_honeypot_silently_drops_bot_submissions(): void
    {
        $response = $this->postJson('/contact', [
            'name' => 'Spam Bot',
            'email' => 'bot@spam.example',
            'message' => 'Buy cheap backlinks right now please click here',
            'website_url' => 'https://spam.example',
        ]);

        $response->assertCreated();
        $this->assertSame(0, ContactInquiry::count());
    }
}

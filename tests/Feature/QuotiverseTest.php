<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Quote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuotiverseTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_quote_and_category_counts(): void
    {
        $category = Category::create(['category_name' => 'Life']);
        Quote::create([
            'quote_text' => 'Keep moving forward.',
            'author' => 'Walt Disney',
            'category_id' => $category->id,
        ]);

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Total Quotes')
            ->assertSee('My Quotes')
            ->assertSee('Keep moving forward.')
            ->assertSee('Walt Disney')
            ->assertSee('Life');
    }

    public function test_quote_can_be_created_updated_searched_filtered_and_deleted(): void
    {
        $life = Category::create(['category_name' => 'Life']);
        $friendship = Category::create(['category_name' => 'Friendship']);

        $this->post(route('quotes.store'), [
            'quote_text' => 'Choose joy every day.',
            'author' => 'Alex Example',
            'category_id' => $life->id,
        ])->assertRedirect(route('quotes.index'));

        $quote = Quote::firstOrFail();

        $this->get(route('quotes.index', ['search' => 'joy', 'category' => $life->id]))
            ->assertOk()
            ->assertSee('Choose joy every day.')
            ->assertSee('Alex Example');

        $this->get(route('quotes.index', ['category' => $friendship->id]))
            ->assertOk()
            ->assertDontSee('Choose joy every day.');

        $this->put(route('quotes.update', $quote), [
            'quote_text' => 'Choose kindness every day.',
            'author' => 'Alex Example',
            'category_id' => null,
        ])->assertRedirect(route('quotes.index'));

        $this->assertDatabaseHas('quotes', [
            'id' => $quote->id,
            'quote_text' => 'Choose kindness every day.',
            'category_id' => null,
        ]);

        $this->delete(route('quotes.destroy', $quote))
            ->assertRedirect(route('quotes.index'));

        $this->assertDatabaseMissing('quotes', ['id' => $quote->id]);
    }

    public function test_quotes_can_be_favorited_and_filtered(): void
    {
        $favorite = Quote::create([
            'quote_text' => 'Choose joy every day.',
            'author' => 'Alex Example',
        ]);
        Quote::create([
            'quote_text' => 'Take a deep breath.',
            'author' => 'Jamie Example',
        ]);

        $this->post(route('quotes.favorite', $favorite))
            ->assertRedirect();

        $this->assertDatabaseHas('quotes', [
            'id' => $favorite->id,
            'is_favorite' => true,
        ]);

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('favoriteCount', 1)
            ->assertSee('Favorite Quotes');

        $this->get(route('quotes.index', ['favorites' => 1]))
            ->assertOk()
            ->assertSee('Choose joy every day.')
            ->assertDontSee('Take a deep breath.');

        $this->post(route('quotes.favorite', $favorite))
            ->assertRedirect();

        $this->assertDatabaseHas('quotes', [
            'id' => $favorite->id,
            'is_favorite' => false,
        ]);
    }

    public function test_categories_can_be_created_renamed_and_deleted_without_deleting_quotes(): void
    {
        $this->post(route('categories.store'), ['category_name' => 'Success'])
            ->assertRedirect(route('categories.index'));

        $category = Category::firstOrFail();
        $quote = Quote::create([
            'quote_text' => 'Small steps matter.',
            'author' => 'A. Writer',
            'category_id' => $category->id,
        ]);

        $this->put(route('categories.update', $category), ['category_name' => 'Growth'])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', ['id' => $category->id, 'category_name' => 'Growth']);

        $this->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('quotes', ['id' => $quote->id, 'category_id' => null]);
    }

    public function test_invalid_quote_and_duplicate_category_are_rejected(): void
    {
        $this->from(route('quotes.create'))
            ->post(route('quotes.store'), [
                'quote_text' => '',
                'author' => '',
                'category_id' => 999,
            ])
            ->assertRedirect(route('quotes.create'))
            ->assertSessionHasErrors(['quote_text', 'author', 'category_id']);

        Category::create(['category_name' => 'Motivation']);

        $this->from(route('categories.create'))
            ->post(route('categories.store'), ['category_name' => 'Motivation'])
            ->assertRedirect(route('categories.create'))
            ->assertSessionHasErrors('category_name');
    }

    public function test_quote_pagination_uses_bootstrap_five_markup(): void
    {
        for ($index = 1; $index <= 10; $index++) {
            Quote::create([
                'quote_text' => "Quote number {$index}.",
                'author' => 'A. Writer',
            ]);
        }

        $this->get(route('quotes.index'))
            ->assertOk()
            ->assertSee('class="pagination"', false)
            ->assertSee('class="page-link"', false);
    }
}

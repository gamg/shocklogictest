<?php

namespace Tests\Feature;

use App\Http\Livewire\Event;
use App\Models\Event as EventModel;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_are_redirected_to_login()
    {
        $this->get('/')
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function event_component_can_be_rendered()
    {
        //$this->loggedIn();
        //$this->get(route('dashboard'))->assertStatus(200)->assertSeeLivewire('event');
        $user = User::factory()->create();
        Livewire::actingAs($user)->test(Event::class)->assertStatus(200);
    }

    /** @test */
    public function component_can_load_events()
    {
        //$this->loggedIn();
        $user = User::factory()->create();

        $events = EventModel::factory(3)->create();

        Livewire::actingAs($user)->test(Event::class)
            ->assertSee($events->first()->name)
            ->assertSee($events->first()->image)
            ->assertSee($events->last()->name)
            ->assertSee($events->last()->image);
    }

    /** @test */
    public function auth_user_can_see_all_event_info()
    {
        //$this->loggedIn();
        $user = User::factory()->create();

        $event = EventModel::factory()->create([
            'start_date' => now(),
            'end_date' => now(),
            'image' => 'eventimage.jpg',
        ]);

        Livewire::actingAs($user)->test(Event::class)
            ->call('loadEvent', $event->id)
            ->assertSee($event->name)
            ->assertSee($event->start_date_formatted)
            ->assertSee($event->end_date_formatted)
            ->assertSee($event->image_url);
    }

    /** @test */
    public function only_admin_can_see_events_actions()
    {
        //$this->loggedIn(admin: true);
        $user = User::factory()->create(['role' => true]);

        EventModel::factory(3)->create();

        Livewire::actingAs($user)->test(Event::class)
            ->assertStatus(200)
            ->assertSee('New Event')
            ->assertSee('Edit')
            ->assertSee('Delete');
    }

    /** @test */
    public function participants_cannot_see_events_actions()
    {
        //$this->loggedIn();
        $user = User::factory()->create();

        EventModel::factory(3)->create();

        Livewire::actingAs($user)->test(Event::class)
            ->assertStatus(200)
            ->assertDontSee('Edit')
            ->assertDontSee('New Project')
            ->assertDontSee('Delete');
    }

    /** @test */
    public function admin_can_add_an_event()
    {
        //$this->loggedIn(admin: true);
        $user = User::factory()->create(['role' => true]);
        $image = UploadedFile::fake()->image('eventimage.jpg');
        Storage::fake('event');

        Livewire::actingAs($user)->test(Event::class)
            ->set('currentEvent.name', 'My new Event')
            ->set('currentEvent.start_date', now())
            ->set('currentEvent.end_date', now())
            ->set('imageFile', $image)
            ->call('save');

        $newEvent = EventModel::first();

        $this->assertDatabaseHas('events', [
            'id' => $newEvent->id,
            'name' => 'My new Event',
            'start_date' => $newEvent->start_date,
            'end_date' => $newEvent->start_date,
        ]);

        Storage::disk('event')->assertExists($newEvent->image);
    }

    /** @test */
    public function admin_can_edit_an_event()
    {
        $user = User::factory()->create(['role' => true]);
        $event = EventModel::factory()->create();
        $img = UploadedFile::fake()->image('eventimage.jpg');
        Storage::fake('event');

        Livewire::actingAs($user)->test(Event::class)
            ->call('loadEvent', $event->id)
            ->set('currentEvent.name', 'My super event updated')
            ->set('currentEvent.start_date', now())
            ->set('currentEvent.end_date', now())
            ->set('imageFile', $img)
            ->call('save');

        $event->refresh();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => 'My super event updated',
            'start_date' => $event->start_date,
            'end_date' => $event->end_date,
            'image' => $event->image,
        ]);

        Storage::disk('event')->assertExists($event->image);
    }

    /** @test */
    public function admin_can_delete_an_event()
    {
        $user = User::factory()->create(['role' => true]);
        $event = EventModel::factory()->create();
        $img = UploadedFile::fake()->image('eventimage.jpg');
        Storage::fake('event');

        Livewire::actingAs($user)->test(Event::class)
            ->call('loadEvent', $event->id)
            ->set('imageFile', $img)
            ->call('save');

        $event->refresh();

        Livewire::actingAs($user)->test(Event::class)
            ->call('deleteEvent', $event->id);

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
        Storage::disk('event')->assertMissing($event->image);
    }

    /** @test */
    public function name_field_is_required()
    {
        $user = User::factory()->create(['role' => true]);

        Livewire::actingAs($user)->test(Event::class)
            ->set('currentEvent.name', '')
            ->call('save')
            ->assertHasErrors(['currentEvent.name' => 'required']);
    }

    /** @test */
    public function name_field_must_have_a_maximum_of_two_hundred_fifty_five_characters()
    {
        $user = User::factory()->create(['role' => true]);

        Livewire::actingAs($user)->test(Event::class)
            ->set('currentEvent.name', '123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890')
            ->call('save')
            ->assertHasErrors(['currentEvent.name' => 'max']);
    }

    /** @test  */
    public function image_file_must_be_a_image()
    {
        $user = User::factory()->create(['role' => true]);

        Livewire::actingAs($user)->test(Event::class)
            ->set('imageFile', UploadedFile::fake()->create('noimage.pdf'))
            ->call('save')
            ->assertHasErrors(['imageFile' => 'image']);
    }
}

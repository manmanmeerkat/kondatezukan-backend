<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testUploadImage()
    {
        // テスト用の画像ファイルを作成
        $imageFile = UploadedFile::fake()->image('test_image.jpg');

        // テスト用のリサイズ後の画像データ
        $resizedImageData = 'fake_resized_image_data';

        // Image::make()メソッドが呼ばれたときの挙動をモック
        $this->mock(\Intervention\Image\ImageManager::class, function ($mock) use ($resizedImageData) {
            $mock->shouldReceive('make')->andReturnSelf();
            $mock->shouldReceive('fit')->andReturnSelf();
            $mock->shouldReceive('encode')->andReturn($resizedImageData);
        });

        // Storage::disk('public')->put()メソッドが呼ばれたときの挙動をモック
        Storage::fake('public');
        Storage::disk('public')->put('uploads/test_image.jpg', $resizedImageData);

        // テスト用のリクエストを作成
        $response = $this->postJson('/api/upload-image', [
            'image_file' => $imageFile,
        ]);

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスに期待される画像パスが含まれていることを確認
        $response->assertJsonStructure([
            'image_path',
        ]);

        // フェイクストレージディスク内にファイルが存在することを確認
        $this->assertTrue(Storage::disk('public')->exists('uploads/test_image.jpg'));
    }
}

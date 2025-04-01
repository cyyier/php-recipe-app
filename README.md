# Recipe（PHPレシピ投稿アプリ）

PHPとMySQLを用い、フレームワークなしでゼロから構築したレシピ投稿アプリです。  
投稿されたレシピは、カテゴリ・材料・手順に分けて管理され、食材量の自動調整やステップごとのタイマー機能を備えています。

このプロジェクトは、PHPによるWebアプリケーションの基本構造理解、およびリレーショナルデータベース設計の実践を目的として開発しました。

---

## 特徴

- **食材量の自動調整機能**  
　主要食材の量に基づき、他の食材の量が自動的に再計算されます。分量変更のたびに手動で修正する必要がありません。

- **ステップ別タイマー機能**  
　各調理ステップにタイマーを設定し、ボタン一つで計時を開始できます。

---

## 技術スタック

- **バックエンド**：PHP 7.3（フレームワーク未使用）
- **データベース**：MySQL 5.7
- **フロントエンド**：HTML / CSS / JavaScript（Bulma使用）

---

## 学んだこと

- PHPによるフォーム処理、ページ遷移、DB連携
- 多対多関係を含む正規化データベース設計
- 中間テーブルの構造とJOINの使い方
- 手順・材料の順番制御のための分離構造
- ER図の自力設計

---

## ER図

<img src="https://github.com/cyyier/recipe/assets/52512369/4afd8d4c-f879-45af-baf9-5a90a7b3e1f3" width="200" alt="ER図">

---

## クリーンショット

<img src="https://github.com/cyyier/recipe/assets/52512369/a01e4ede-9cdf-40fc-8be4-42b32e5d9d80" width="200">
<img src="https://github.com/cyyier/recipe/assets/52512369/a3a221c4-e1ad-4956-9c72-bf8013ab405d" width="200">
<img src="https://github.com/cyyier/recipe/assets/52512369/6b2e02b3-bfd1-4c51-bf2f-64e9aeab985b" width="200">
<img src="https://github.com/cyyier/recipe/assets/52512369/d804c348-f6d9-46b5-b913-ed2d2db4b038" width="200">
<img src="https://github.com/cyyier/recipe/assets/52512369/f4ed14e3-6c2e-42f5-999c-fe012b787ac4" width="200">
<img src="https://github.com/cyyier/recipe/assets/52512369/4c4c9279-4a97-49d0-907a-941b7702ae5a" width="200">
<img src="https://github.com/cyyier/recipe/assets/52512369/dcdeb521-b649-4940-a50e-1358c69922c3" width="200">
<img src="https://github.com/cyyier/recipe/assets/52512369/fb1e2e2a-50d2-408b-b370-b30dfae7125f" width="200">

---

## 注意事項

- 著作権の関係により、一部の画像・フォント・音声ファイルは削除されています。

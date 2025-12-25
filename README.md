# Minecraft Player Manager for Pelican Panel

[English](#english) | [日本語](#japanese) | [German](#deutsch)

---

<a name="english"></a>
## 🇬🇧 English

### ⚠️ Note from the Developer
**I am a Japanese developer.**
While I strive to provide support in English, please understand that my responses might be delayed or rely on translation tools. I appreciate your patience and understanding!

### Overview
**Minecraft Player Manager** is a plugin for [Pelican Panel](https://pelican.dev/) that allows you to manage players on your Minecraft servers directly from the panel.
View real-time status with RCON, check inventories, and perform administrative actions like Kick, Ban, and OP/Deop without entering the game.

### Features
*   **Real-time Player List**: View all known players (Online, Offline, Banned, OP).
*   **Visual Stats**:
    *   Health (Hearts) and Food (Drumsticks) visualization.
    *   Experience Level, Gamemode.
    *   Statistics from world data (Play time, Mobs killed, Distance walked, Deaths).
*   **Inventory Viewer**:
    *   Visual representation of player inventory and armor slots.
*   **Management Actions**:
    *   **kick**: Kick a player from the server.
    *   **ban**: Ban a player (with reason).
    *   **op / deop**: Grant or revoke operator status.
    *   **clear inventory**: Wipe a player's items.
*   **Multi-language Support**: Fully localized in English and Japanese.

### Requirements
*   **PHP**: 8.2 or higher
*   **Node.js**: v20 or higher
*   **Yarn**: v1.22 or higher
*   **Pelican Panel**: v1.0.0 or higher
*   **Minecraft Server**:
    *   **Java Edition**: Version 1.13+ recommended (for Data Command support).
    *   **RCON**: Must be enabled (`enable-rcon=true` and valid port/password).
    *   **Query**: Must be enabled (`enable-query=true`) for real-time player listing.

### Installation
1.  Download the plugin release.
2.  Upload the plugin to your Pelican Panel's `plugins` directory.
3.  Install via the Panel Administration page.

### Usage
1.  Navigate to the **Server View** in Pelican Panel.
2.  Click on the **Player** tab in the navigation menu.
3.  You will see a list of players. Click "View" (or "詳細") to see real-time details and inventory.

---

<a name="japanese"></a>
## 🇯🇵 日本語

### 概要
**Minecraft Player Manager** は、[Pelican Panel](https://pelican.dev/) 上でマインクラフトサーバーのプレイヤーを直接管理できるプラグインです。
RCONを使用してリアルタイムのステータスを確認したり、インベントリを閲覧したり、Kick・Ban・OP権限の付与といった管理操作をパネルから行うことができます。

### 機能
*   **リアルタイムプレイヤーリスト**: 参加プレイヤーの一覧表示（オンライン、オフライン、BAN済み、OP）。
*   **ビジュアルステータス**:
    *   体力（ハート）と満腹度（肉）をアイコンで視覚的に表示。
    *   XPレベル、ゲームモードの確認。
    *   ワールドデータに基づく統計情報（プレイ時間、モブ討伐数、移動距離、死亡回数）。
*   **インベントリビューアー**:
    *   プレイヤーのインベントリと装備（防具）を視覚的に確認可能。
*   **管理アクション**:
    *   **Kick**: プレイヤーをサーバーから切断。
    *   **Ban**: プレイヤーをBAN（理由入力可）。
    *   **OP / Deop**: 管理者権限の付与・剥奪。
    *   **インベントリ消去**: アイテムの全削除。
*   **多言語対応**: そのままの環境で日本語・英語に対応しています。

### 推奨環境 / 必須設定
*   **PHP**: 8.2 以上
*   **Node.js**: v20 以上
*   **Yarn**: v1.22 以上
*   **Pelican Panel**: v1.0.0 以上
*   **Minecraft サーバー**:
    *   **Java Edition**: 1.13以上推奨（Dataコマンドの互換性のため）
    *   **RCON**: 有効化必須（`enable-rcon=true` およびポート・パスワード設定）
    *   **Query**: プレイヤーリスト取得のため有効化必須（`enable-query=true`）

### インストール方法
1.  プラグインをダウンロードします。
2.  Pelican Panelの `plugins` ディレクトリにアップロードします。
3.  管理画面からプラグインを有効化・インストールしてください。

### 使い方
1.  Pelican Panelで対象の **サーバー画面** を開きます。
2.  ナビゲーションメニューの **Player**（または「ゲームプレイヤー」）をクリックします。
3.  プレイヤー一覧が表示されます。「詳細」ボタンをクリックすると、リアルタイムな情報やインベントリを確認できます。

---

<a name="deutsch"></a>
## 🇩🇪 Deutsch

### ⚠️ Hinweis des Entwicklers
**Ich bin ein japanischer Entwickler.**  
Ich bemühe mich, Support auf Englisch anzubieten. Bitte habe Verständnis, falls Antworten verzögert sind oder Übersetzungstools verwendet werden. Vielen Dank für deine Geduld!

### Überblick
**Minecraft Player Manager** ist ein Plugin für das [Pelican Panel](https://pelican.dev/), mit dem du Spieler auf deinen Minecraft-Servern direkt über das Panel verwalten kannst.  
Du kannst den Spielerstatus in Echtzeit über RCON einsehen, Inventare prüfen und administrative Aktionen wie Kick, Ban oder OP/Deop ausführen, ohne das Spiel zu betreten.

### Funktionen
* **Echtzeit-Spielerliste**: Anzeige aller bekannten Spieler (Online, Offline, Gebannt, OP).
* **Visuelle Statistiken**:
  * Leben (Herzen) und Hunger (Keulen).
  * Erfahrungslevel, Spielmodus.
  * Statistiken aus Weltdaten (Spielzeit, getötete Mobs, zurückgelegte Distanz, Tode).
* **Inventar-Viewer**:
  * Visuelle Darstellung des Spielerinventars und der Rüstungsslots.
* **Verwaltungsaktionen**:
  * **kick**: Einen Spieler vom Server kicken.
  * **ban**: Einen Spieler bannen (mit Begründung).
  * **op / deop**: Operator-Rechte vergeben oder entziehen.
  * **Inventar leeren**: Alle Items eines Spielers entfernen.
* **Mehrsprachige Unterstützung**: Vollständig lokalisiert auf Englisch und Japanisch.

### Voraussetzungen
* **PHP**: 8.2 oder höher
* **Node.js**: v20 oder höher
* **Yarn**: v1.22 oder höher
* **Pelican Panel**: v1.0.0 oder höher
* **Minecraft-Server**:
  * **Java Edition**: Version 1.13+ empfohlen (für Data-Command-Unterstützung).
  * **RCON**: Muss aktiviert sein (`enable-rcon=true` sowie gültiger Port und Passwort).
  * **Query**: Muss aktiviert sein (`enable-query=true`) für die Echtzeit-Spielerliste.

### Installation
1. Plugin-Release herunterladen.
2. Das Plugin in das `plugins`-Verzeichnis deines Pelican Panels hochladen.
3. Über die Administrationsseite des Panels installieren.

### Nutzung
1. Öffne die **Server-Ansicht** im Pelican Panel.
2. Klicke im Navigationsmenü auf den Tab **Spieler**.
3. Du siehst eine Spielerliste. Klicke auf „Ansehen“ (oder „View“), um Echtzeitdetails und das Inventar anzuzeigen.

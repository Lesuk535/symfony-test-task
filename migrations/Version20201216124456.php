<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216124456 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN brand.id IS \'(DC2Type:brand_id)\'');
        $this->addSql('CREATE TABLE catalog (id UUID NOT NULL, parent_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, catalog_order INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B2C32474C3AF221 ON catalog (catalog_order)');
        $this->addSql('CREATE INDEX IDX_1B2C3247727ACA70 ON catalog (parent_id)');
        $this->addSql('COMMENT ON COLUMN catalog.id IS \'(DC2Type:catalog_id)\'');
        $this->addSql('COMMENT ON COLUMN catalog.parent_id IS \'(DC2Type:catalog_id)\'');
        $this->addSql('COMMENT ON COLUMN catalog.status IS \'(DC2Type:catalog_status)\'');
        $this->addSql('CREATE TABLE product_filters (id UUID NOT NULL, attributes JSONB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN product_filters.id IS \'(DC2Type:product_id)\'');
        $this->addSql('CREATE TABLE product_images (id UUID NOT NULL, product_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8263FFCE4584665A ON product_images (product_id)');
        $this->addSql('COMMENT ON COLUMN product_images.id IS \'(DC2Type:product_id)\'');
        $this->addSql('COMMENT ON COLUMN product_images.product_id IS \'(DC2Type:product_id)\'');
        $this->addSql('CREATE TABLE products (id UUID NOT NULL, brand_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, description TEXT NOT NULL, quantity INT NOT NULL, price BIGINT NOT NULL, percent_discount INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A44F5D008 ON products (brand_id)');
        $this->addSql('COMMENT ON COLUMN products.id IS \'(DC2Type:product_id)\'');
        $this->addSql('COMMENT ON COLUMN products.brand_id IS \'(DC2Type:brand_id)\'');
        $this->addSql('COMMENT ON COLUMN products.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN products.status IS \'(DC2Type:product_status)\'');
        $this->addSql('CREATE TABLE products_categories (product_id UUID NOT NULL, category_id UUID NOT NULL, PRIMARY KEY(product_id, category_id))');
        $this->addSql('CREATE INDEX IDX_E8ACBE764584665A ON products_categories (product_id)');
        $this->addSql('CREATE INDEX IDX_E8ACBE7612469DE2 ON products_categories (category_id)');
        $this->addSql('COMMENT ON COLUMN products_categories.product_id IS \'(DC2Type:product_id)\'');
        $this->addSql('COMMENT ON COLUMN products_categories.category_id IS \'(DC2Type:catalog_id)\'');
        $this->addSql('CREATE TABLE products_filters (product_id UUID NOT NULL, filter_id UUID NOT NULL, PRIMARY KEY(product_id, filter_id))');
        $this->addSql('CREATE INDEX IDX_A34A9DD04584665A ON products_filters (product_id)');
        $this->addSql('CREATE INDEX IDX_A34A9DD0D395B25E ON products_filters (filter_id)');
        $this->addSql('COMMENT ON COLUMN products_filters.product_id IS \'(DC2Type:product_id)\'');
        $this->addSql('COMMENT ON COLUMN products_filters.filter_id IS \'(DC2Type:product_id)\'');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT FK_1B2C3247727ACA70 FOREIGN KEY (parent_id) REFERENCES catalog (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_images ADD CONSTRAINT FK_8263FFCE4584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products_categories ADD CONSTRAINT FK_E8ACBE764584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products_categories ADD CONSTRAINT FK_E8ACBE7612469DE2 FOREIGN KEY (category_id) REFERENCES catalog (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products_filters ADD CONSTRAINT FK_A34A9DD04584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products_filters ADD CONSTRAINT FK_A34A9DD0D395B25E FOREIGN KEY (filter_id) REFERENCES product_filters (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A44F5D008');
        $this->addSql('ALTER TABLE catalog DROP CONSTRAINT FK_1B2C3247727ACA70');
        $this->addSql('ALTER TABLE products_categories DROP CONSTRAINT FK_E8ACBE7612469DE2');
        $this->addSql('ALTER TABLE products_filters DROP CONSTRAINT FK_A34A9DD0D395B25E');
        $this->addSql('ALTER TABLE product_images DROP CONSTRAINT FK_8263FFCE4584665A');
        $this->addSql('ALTER TABLE products_categories DROP CONSTRAINT FK_E8ACBE764584665A');
        $this->addSql('ALTER TABLE products_filters DROP CONSTRAINT FK_A34A9DD04584665A');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE catalog');
        $this->addSql('DROP TABLE product_filters');
        $this->addSql('DROP TABLE product_images');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE products_categories');
        $this->addSql('DROP TABLE products_filters');
    }
}
